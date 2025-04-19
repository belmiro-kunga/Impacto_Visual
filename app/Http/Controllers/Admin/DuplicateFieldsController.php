<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Content;

class DuplicateFieldsController extends Controller
{
    // Tabelas a serem verificadas para duplicatas
    protected $tables = [
        'services' => ['title', 'description'],
        'portfolios' => ['title', 'description'],
        'contents' => ['key', 'value']
    ];

    /**
     * Exibe a página inicial da ferramenta de campos duplicados
     */
    public function index()
    {
        // Buscar grupos de conteúdos duplicados para a view original
        $duplicateGroups = $this->getContentDuplicates();
        
        // Se não estiver usando nova interface, use a anterior
        if (request()->query('old') === '1') {
            return view('admin.duplicate-fields', compact('duplicateGroups'));
        }
        
        return view('admin.duplicate_fields.index');
    }

    /**
     * Obter grupos de conteúdos duplicados
     */
    private function getContentDuplicates()
    {
        $groups = [];
        
        // Buscar grupos com chaves duplicadas
        $duplicateKeys = Content::select('key', 'section')
            ->groupBy('key', 'section')
            ->havingRaw('COUNT(*) > 1')
            ->get();
            
        foreach ($duplicateKeys as $item) {
            $fields = Content::where('key', $item->key)
                ->where('section', $item->section)
                ->get();
                
            $groups[] = [
                'key' => $item->key,
                'section' => $item->section,
                'count' => $fields->count(),
                'fields' => $fields
            ];
        }
        
        return $groups;
    }

    /**
     * Escaneia as tabelas em busca de campos duplicados
     */
    public function scan()
    {
        $duplicates = [];

        foreach ($this->tables as $table => $fields) {
            // Verifica se a tabela existe
            if (!Schema::hasTable($table)) {
                continue;
            }

            foreach ($fields as $field) {
                // Verifica se o campo existe na tabela
                if (!Schema::hasColumn($table, $field)) {
                    continue;
                }

                // Busca valores duplicados
                $query = DB::table($table)
                    ->select($field, DB::raw('COUNT(*) as count'), DB::raw('GROUP_CONCAT(id) as ids'))
                    ->groupBy($field)
                    ->having('count', '>', 1);
                
                // Exclui valores vazios
                $query->whereNotNull($field)->where($field, '!=', '');
                
                $results = $query->get();

                // Se encontrou duplicatas, adiciona ao array de resultados
                if ($results->count() > 0) {
                    foreach ($results as $result) {
                        $duplicates[] = [
                            'table' => $table,
                            'field' => $field,
                            'value' => $result->$field,
                            'count' => $result->count,
                            'ids' => explode(',', $result->ids)
                        ];
                    }
                }
            }
        }

        return response()->json(['duplicates' => $duplicates]);
    }

    /**
     * Corrige os campos duplicados
     */
    public function fix(Request $request)
    {
        $table = $request->input('table');
        $field = $request->input('field');
        $ids = $request->input('ids');
        $newValues = $request->input('new_values');

        // Validação básica
        if (!in_array($table, array_keys($this->tables)) || 
            !in_array($field, $this->tables[$table])) {
            return response()->json(['error' => 'Tabela ou campo inválido'], 400);
        }

        if (!is_array($ids) || !is_array($newValues) || count($ids) != count($newValues)) {
            return response()->json(['error' => 'Dados inválidos'], 400);
        }

        try {
            // Atualiza cada registro com o novo valor
            foreach ($ids as $index => $id) {
                DB::table($table)
                    ->where('id', $id)
                    ->update([$field => $newValues[$index]]);
            }

            return response()->json(['success' => true, 'message' => 'Campos atualizados com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar: ' . $e->getMessage()], 500);
        }
    }
    
    /**
     * Remove campos duplicados mantendo apenas um
     */
    public function remove(Request $request)
    {
        $keepIds = $request->input('keep_ids', []);
        
        if (empty($keepIds)) {
            return redirect()->back()->with('error', 'Nenhum campo selecionado para manter.');
        }
        
        $removed = 0;
        
        foreach ($keepIds as $key => $keepId) {
            // Buscar todos os campos com a mesma chave
            $keyParts = explode(':', $key);
            $contentKey = $keyParts[0]; 
            $section = isset($keyParts[1]) ? $keyParts[1] : '';
            
            $query = Content::where('key', $contentKey);
            if (!empty($section)) {
                $query->where('section', $section);
            }
            
            $duplicates = $query->where('id', '!=', $keepId)->get();
            
            // Remover duplicatas
            foreach ($duplicates as $duplicate) {
                $duplicate->delete();
                $removed++;
            }
        }
        
        return redirect()->route('admin.duplicate-fields.index')
            ->with('success', "Campos duplicados removidos com sucesso! ($removed campos removidos)");
    }
    
    /**
     * Remove automaticamente todos os campos duplicados, mantendo o primeiro de cada grupo
     */
    public function removeAll()
    {
        $duplicateGroups = $this->getContentDuplicates();
        $removed = 0;
        
        foreach ($duplicateGroups as $group) {
            // Manter o primeiro campo e remover os demais
            $firstField = $group['fields']->first();
            
            foreach ($group['fields'] as $field) {
                if ($field->id != $firstField->id) {
                    $field->delete();
                    $removed++;
                }
            }
        }
        
        return redirect()->route('admin.duplicate-fields.index')
            ->with('success', "Todos os campos duplicados foram removidos automaticamente! ($removed campos removidos)");
    }
} 