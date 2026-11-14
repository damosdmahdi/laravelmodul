<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class BelajarController extends Controller
{
    /**
     * Dashboard Portal Pembelajaran & Simulator
     */
    public function index()
    {
        return view('belajar.index');
    }

    /**
     * Modul 1: Peta Interaktif Struktur Folder
     */
    public function modul1()
    {
        return view('belajar.modul1');
    }

    /**
     * Modul 2: Simulator Alur MVC (Request Pipeline Animation)
     */
    public function modul2()
    {
        return view('belajar.modul2');
    }

    /**
     * Modul 3: Blade Templating Studio
     */
    public function modul3()
    {
        return view('belajar.modul3');
    }

    /**
     * Modul 4: Database & Migration Architect
     */
    public function modul4()
    {
        $items = Item::all();
        return view('belajar.modul4', compact('items'));
    }

    /**
     * Modul 5: Eloquent ORM & Form CSRF Inspector
     */
    public function modul5()
    {
        $items = Item::all();
        return view('belajar.modul5', compact('items'));
    }

    /**
     * Modul 6: CRUD Complete & Form Validation Lab
     */
    public function modul6()
    {
        return view('belajar.modul6');
    }
}
