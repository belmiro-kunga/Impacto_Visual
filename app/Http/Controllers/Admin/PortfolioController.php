<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     * Exibir a lista de itens do portfólio.
     */
    public function index()
    {
        $portfolios = Portfolio::orderBy('order')->get();
        return view('admin.portfolio.index', compact('portfolios'));
    }

    /**
     * Exibir o formulário para criar um novo item.
     */
    public function create()
    {
        return view('admin.portfolio.form');
    }

    /**
     * Armazenar um novo item no banco de dados.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'youtube_id' => 'required|max:255',
            'thumbnail' => 'nullable|max:255',
            'order' => 'integer',
            'active' => 'boolean',
        ]);

        Portfolio::create($validated);

        return redirect()->route('admin.portfolio.index')->with('success', 'Item adicionado com sucesso!');
    }

    /**
     * Exibir o formulário para editar um item existente.
     */
    public function edit(Portfolio $portfolio)
    {
        return view('admin.portfolio.form', compact('portfolio'));
    }

    /**
     * Atualizar um item existente no banco de dados.
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'youtube_id' => 'required|max:255',
            'thumbnail' => 'nullable|max:255',
            'order' => 'integer',
            'active' => 'boolean',
        ]);

        $portfolio->update($validated);

        return redirect()->route('admin.portfolio.index')->with('success', 'Item atualizado com sucesso!');
    }

    /**
     * Remover um item do banco de dados.
     */
    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();

        return redirect()->route('admin.portfolio.index')->with('success', 'Item removido com sucesso!');
    }
}
