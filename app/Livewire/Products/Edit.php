<?php

namespace App\Livewire\Products;

use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Cloudinary\Cloudinary;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public Product $product;

    public string $name = '';

    public string $sku = '';

    public string $category_id = '';

    public string $unit_id = '';

    public string $price = '';

    public string $cost_price = '';

    public int $stock = 0;

    public int $min_stock = 5;

    public string $description = '';

    public bool $is_active = true;

    public $image;

    public ?string $existingImage = null;

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->name = $product->name;
        $this->sku = $product->sku;
        $this->category_id = (string) $product->category_id;
        $this->unit_id = (string) $product->unit_id;
        $this->price = (string) $product->price;
        $this->cost_price = (string) $product->cost_price;
        $this->stock = $product->stock;
        $this->min_stock = $product->min_stock;
        $this->description = $product->description ?? '';
        $this->is_active = $product->is_active;
        $this->existingImage = $product->image;
    }

    protected function rules()
    {
        return [
            'name' => 'required|min:2',
            'sku' => 'required|unique:products,sku,'.$this->product->id,
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'description' => 'nullable',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048',
        ];
    }

    public function save()
    {
        $this->validate();

        $imageName = $this->existingImage;

        if ($this->image) {
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => config('cloudinary.cloud_name'),
                    'api_key' => config('cloudinary.api_key'),
                    'api_secret' => config('cloudinary.api_secret'),
                ],
            ]);

            // Hapus gambar lama dari Cloudinary jika ada
            if ($this->existingImage) {
                $publicId = pathinfo(parse_url($this->existingImage, PHP_URL_PATH), PATHINFO_FILENAME);
                $cloudinary->uploadApi()->destroy('pos-products/'.$publicId);
            }

            $result = $cloudinary->uploadApi()->upload($this->image->getRealPath(), [
                'folder' => 'pos-products',
            ]);
            $imageName = $result['secure_url'];
        }

        $this->product->update([
            'name' => $this->name,
            'sku' => $this->sku,
            'category_id' => $this->category_id,
            'unit_id' => $this->unit_id,
            'price' => $this->price,
            'cost_price' => $this->cost_price,
            'stock' => $this->stock,
            'min_stock' => $this->min_stock,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'image' => $imageName,
        ]);

        session()->flash('success', 'Produk berhasil diupdate!');

        return redirect()->route('products.index');
    }

    public function render()
    {
        return view('livewire.products.edit', [
            'categories' => Category::all(),
            'units' => Unit::all(),
        ]);
    }
}
