<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class AdminProducts extends Component
{
    public $products;
    public $name, $price, $stock_quantity, $editingId = null;
    public $search                                    = '';

    use WithPagination;

    protected $rules = [
        'name'           => 'required|string|max:255',
        'price'          => 'required|numeric|min:0.01',
        'stock_quantity' => 'required|integer|min:0',
    ];

    public function mount()
    {
        if(!Auth::user()->is_admin) abort(403);
        $this->products = Product::all();
    }

    public function render()
    {
        $products = Product::when($this->search, function ($query) {
            $query->where('name', 'like', "%{$this->search}%");
        })->paginate(10);

        return view('livewire.admin-product', compact('products'));

    }


    public function createProduct()
    {
        $this->validate();
        Product::create([
            'name'           => $this->name,
            'price'          => $this->price,
            'stock_quantity' => $this->stock_quantity,
        ]);
        $this->resetForm();
        session()->flash('message', 'Product created.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->editingId = $id;
        $this->name = $product->name;
        $this->price = $product->price;
        $this->stock_quantity = $product->stock_quantity;
    }

    public function update()
    {
        $this->validate();
        $product = Product::findOrFail($this->editingId);
        $product->update([
            'name'           => $this->name,
            'price'          => $this->price,
            'stock_quantity' => $this->stock_quantity,
        ]);
        $this->resetForm();
        session()->flash('message', 'Product updated.');
    }

    public function delete($id)
    {
        Product::destroy($id);
        session()->flash('message', 'Product deleted.');
    }

    public function resetForm()
    {
        $this->reset(['name', 'price', 'stock_quantity', 'editingId']);
    }

}
