<?php


namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public string $name        = '';
    public string $sku         = '';
    public string $category_id = '';
    public string $unit_id     = '';
    public string $price       = '';
    public string $cost_price  = '';
    public int    $stock       = 0;
    public int    $min_stock   = 5;
    public string $description = '';
    public bool   $is_active   = true;
    public $image;

    protected $rules = [
        'name'        => 'required|min:2',
        'sku'         => 'required|unique:products,sku',
        'category_id' => 'required|exists:categories,id',
        'unit_id'     => 'required|exists:units,id',
        'price'       => 'required|numeric|min:0',
        'cost_price'  => 'required|numeric|min:0',
        'stock'       => 'required|integer|min:0',
        'min_stock'   => 'required|integer|min:0',
        'description' => 'nullable',
        'is_active'   => 'boolean',
        'image'       => 'nullable|image|max:2048',
    ];

    public function generateSku()
    {
        $this->sku = 'PRD-' . strtoupper(uniqid());
    }

    public function save()
    {
        $this->validate();

        // ✅ Pakai Laravel Storage — lebih stabil di Windows
       $imageName = null;
if ($this->image) {
    $cloudinary = new \Cloudinary\Cloudinary([
        'cloud' => [
            'cloud_name' => config('cloudinary.cloud_name'),
            'api_key'    => config('cloudinary.api_key'),
            'api_secret' => config('cloudinary.api_secret'),
        ],
    ]);
    $result    = $cloudinary->uploadApi()->upload($this->image->getRealPath(), [
        'folder' => 'pos-products',
    ]);
    $imageName = $result['secure_url'];
}

        Product::create([
            'name'        => $this->name,
            'sku'         => $this->sku,
            'category_id' => $this->category_id,
            'unit_id'     => $this->unit_id,
            'price'       => $this->price,
            'cost_price'  => $this->cost_price,
            'stock'       => $this->stock,
            'min_stock'   => $this->min_stock,
            'description' => $this->description,
            'is_active'   => $this->is_active,
            'image'       => $imageName,
        ]);

        session()->flash('success', 'Produk berhasil ditambahkan!');
        return redirect()->route('products.index');
    }

    public function render()
    {
        return view('livewire.products.create', [
            'categories' => Category::all(),
            'units'      => Unit::all(),
        ]);
    }
}