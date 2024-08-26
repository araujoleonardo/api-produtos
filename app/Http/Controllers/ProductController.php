<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $product = Product::orderBy('created_at');

        if ($request->pesquisa) {
            $product->where('name', 'LIKE', "%{$request->pesquisa}%")
                ->orWhere('description', 'LIKE', "%{$request->pesquisa}%");
        }

        return response()->json([
            'product' => $product->paginate(10),
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
        $request->validate([
            'image'         => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ],
            [
                'image.required'    => 'O campo imagem é obrigatório.',
                'image.image'       => 'O arquivo fornecido deve ser uma imagem.',
                'image.mimes'       => 'A imagem deve ser do tipo jpg, png ou jpeg.',
                'image.max'         => 'A imagem não deve exceder 2 MB.',
            ]);

        try {
            $product = new Product();
            $product->name          = $request->name;
            $product->description   = $request->description;
            $product->price         = str_replace(['R$', ','], ['', '.'], $request->price);
            $product->expiry_date   = Carbon::parse($request->expiry_date)->format('Y-m-d');
            $product->category_id   = $request->category_id;

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image');
                // Gera um nome único para a imagem
                $imageName = time() . '.' . $image->getClientOriginalExtension();

                $path = public_path('imagens');

                $image->move($path, $imageName);

                $product->image = 'imagens/' . $imageName;
            }

            $product->save();

            return response()->json(['success' => 'Produto criado com sucesso!'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Falha ao criar produto!'], Response::HTTP_INTERNAL_SERVER_ERROR);
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
        if ($request->image) {
            $request->validate([
                'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            ],
                [
                    'image.required' => 'O campo imagem é obrigatório.',
                    'image.image' => 'O arquivo fornecido deve ser uma imagem.',
                    'image.mimes' => 'A imagem deve ser do tipo jpg, png ou jpeg.',
                    'image.max' => 'A imagem não deve exceder 2 MB.',
                ]);
        }

        $product = Product::findOrFail($request->id);

        try {
            $product->name          = $request->name;
            $product->description   = $request->description;
            $product->price         = str_replace(['R$', ','], ['', '.'], $request->price);
            $product->expiry_date   = Carbon::parse($request->expiry_date)->format('Y-m-d');
            $product->category_id   = $request->category_id;

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image');
                // Gera um nome único para a imagem
                $imageName = time() . '.' . $image->getClientOriginalExtension();

                $path = public_path('imagens');

                $image->move($path, $imageName);

                $product->image = 'imagens/' . $imageName;
            }

            $product->update();

            return response()->json(['success' => 'Produto atualizado com sucesso!'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Falha ao atualizar produto!'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        try {
            $product->delete();

            return response()->json(['success' => 'Produto excluído com sucesso!'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Não foi possível excluir o produto!'], Response::HTTP_NOT_FOUND);
        }
    }
}
