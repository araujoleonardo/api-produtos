<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category = Category::orderBy('created_at');

        if($request->pesquisa)
        {
            $category->where('name', 'LIKE', "%{$request->pesquisa}%");
        }

        return response()->json([
            'category' => $category->paginate(10),
        ]);
    }

    public function list()
    {
        $category = Category::get();

        return response()->json([
            'categories' => $category,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $category = new Category();
            $category->name     = $request->name;
            $category->save();

            return response()->json(['success' => 'Categoria criada com sucesso!'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Falha ao criar categoria!'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $category = Category::findOrFail($request->id);

        try {
            $category->name     = $request->name;
            $category->update();

            return response()->json(['success' => 'Categoria atualizada com sucesso!'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Falha ao atualizar categoria!'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        try {
            $category->delete();

            return response()->json(['success' => 'Categoria excluída com sucesso!'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Não foi possível excluir a categoria!'], Response::HTTP_NOT_FOUND);
        }
    }
}
