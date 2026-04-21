<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerCatalogController extends Controller
{
    // Dummy data kamera
    private function cameras()
    {
        return [
            ['id' => 1, 'name' => 'Canon EOS R6', 'category' => 'Camera', 'price' => 250000, 'price_label' => 'Rp 250k/hari', 'img' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&q=80&w=600', 'desc' => 'Kamera mirrorless full-frame dengan autofocus canggih, cocok untuk foto dan video profesional.', 'spec' => '20.1MP, 4K Video, Dual Card Slot, IBIS'],
            ['id' => 2, 'name' => 'Sony A7 III', 'category' => 'Camera', 'price' => 300000, 'price_label' => 'Rp 300k/hari', 'img' => 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?auto=format&fit=crop&q=80&w=600', 'desc' => 'Sony A7 III dengan dynamic range luar biasa, pilihan favorit videografer dan fotografer.', 'spec' => '24.2MP, 4K Video, 693 AF Points, Eye-AF'],
            ['id' => 3, 'name' => 'Fujifilm X-T5', 'category' => 'Camera', 'price' => 200000, 'price_label' => 'Rp 200k/hari', 'img' => 'https://images.unsplash.com/photo-1493361912939-20dc5c4aad3f?auto=format&fit=crop&q=80&w=600', 'desc' => 'Kamera retro modern dengan warna film simulasi khas Fujifilm yang ikonik.', 'spec' => '40MP, Film Simulation, 6.2K Video'],
            ['id' => 4, 'name' => 'DJI Pocket 3', 'category' => 'Camera', 'price' => 150000, 'price_label' => 'Rp 150k/hari', 'img' => 'https://images.unsplash.com/photo-1514446945-4564a5674fb4?auto=format&fit=crop&q=80&w=600', 'desc' => 'Kamera gimbal pocket ultra-compact untuk vlog dan konten harian yang smooth.', 'spec' => '4K/120fps, 3-Axis Gimbal, OLED Screen'],
        ];
    }

    // Dummy data camping
    private function campings()
    {
        return [
            ['id' => 5, 'name' => 'Tenda Ultralight 2P', 'category' => 'Camping', 'price' => 100000, 'price_label' => 'Rp 100k/hari', 'img' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&q=80&w=600', 'desc' => 'Tenda ultralight untuk 2 orang, mudah dipasang dan tahan angin hingga 60 km/jam.', 'spec' => '2 Person, 1.8kg, Waterproof 3000mm'],
            ['id' => 6, 'name' => 'Sleeping Bag -5°C', 'category' => 'Camping', 'price' => 50000, 'price_label' => 'Rp 50k/hari', 'img' => 'https://images.unsplash.com/photo-1520390138845-fd2d229dd553?auto=format&fit=crop&q=80&w=600', 'desc' => 'Sleeping bag bulu angsa untuk suhu ekstrem, cocok untuk mendaki gunung tinggi.', 'spec' => 'Down Fill, -5°C Comfort, 900g'],
            ['id' => 7, 'name' => 'Portable Cooking Set', 'category' => 'Camping', 'price' => 60000, 'price_label' => 'Rp 60k/hari', 'img' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?auto=format&fit=crop&q=80&w=600', 'desc' => 'Set masak lengkap untuk 2-3 orang, ringan dan kompak dalam satu tas kecil.', 'spec' => 'Titanium, 4 Piece Set, 350g'],
            ['id' => 8, 'name' => 'Trekking Pole Carbon', 'category' => 'Camping', 'price' => 40000, 'price_label' => 'Rp 40k/hari', 'img' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?auto=format&fit=crop&q=80&w=600', 'desc' => 'Tongkat trekking carbon fiber, ringan namun kuat untuk medan pendakian berat.', 'spec' => 'Carbon Fiber, Adjustable 100-135cm, 240g/pair'],
        ];
    }

    public function home()
    {
        $cameras  = array_slice($this->cameras(), 0, 2);
        $campings = array_slice($this->campings(), 0, 2);
        return view('pelanggan.home', compact('cameras', 'campings'));
    }

    public function camera()
    {
        $products = $this->cameras();
        return view('pelanggan.catalog-camera', compact('products'));
    }

    public function camping()
    {
        $products = $this->campings();
        return view('pelanggan.catalog-camping', compact('products'));
    }

    public function detail($id)
    {
        $all = array_merge($this->cameras(), $this->campings());
        $product = collect($all)->firstWhere('id', (int)$id);
        abort_if(!$product, 404);
        return view('pelanggan.product-detail', compact('product'));
    }
}