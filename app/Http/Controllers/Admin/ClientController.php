<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::orderBy('order')->get();
        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'order' => 'nullable|integer|min:0',
            'active' => 'boolean'
        ], [
            'logo.image' => 'O arquivo deve ser uma imagem.',
            'logo.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif ou webp.',
            'logo.max' => 'A imagem não pode ser maior que 2MB.',
            'website.url' => 'O website deve ser uma URL válida.'
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('clients', 'public');
        }

        Client::create($validated);

        return redirect()->route('admin.clients.index')
            ->with('success', 'Cliente adicionado com sucesso!');
    }

    public function edit(Client $client)
    {
        return view('admin.clients.form', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'order' => 'nullable|integer|min:0',
            'active' => 'boolean'
        ], [
            'logo.image' => 'O arquivo deve ser uma imagem.',
            'logo.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg, gif ou webp.',
            'logo.max' => 'A imagem não pode ser maior que 2MB.',
            'website.url' => 'O website deve ser uma URL válida.'
        ]);

        if ($request->hasFile('logo')) {
            if ($client->logo) {
                Storage::disk('public')->delete($client->logo);
            }
            $validated['logo'] = $request->file('logo')->store('clients', 'public');
        }

        $client->update($validated);

        return redirect()->route('admin.clients.index')
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(Client $client)
    {
        if ($client->logo) {
            Storage::disk('public')->delete($client->logo);
        }
        
        $client->delete();

        return redirect()->route('admin.clients.index')
            ->with('success', 'Cliente excluído com sucesso!');
    }

    public function toggleStatus(Client $client)
    {
        $client->update([
            'active' => !$client->active
        ]);

        return response()->json([
            'success' => true,
            'active' => $client->active,
            'message' => $client->active ? 'Cliente ativado com sucesso!' : 'Cliente desativado com sucesso!'
        ]);
    }

    public function show(Client $client)
    {
        return response()->json($client);
    }
} 