<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;

class categoryController extends Controller
{
    public function getCategory(){
        return response()->json(category::all(), 200);
    }

    public function getCategoryById($id){
        $category = category::find($id);
        if( !$category ){
            return response()->json(['msg'=>'Categoría no encontrada'], 404);
        }

        return response()->json($category, 200);
    }

    public function createCategory(Request $request){

        $validateData = $request->validate([
            'cat_nom' => 'required|string|max:255',
            'cat_obs' => 'required|string|max:255'
        ],[
            'cat_nom.required' => 'El nombre de la categoría es requerido',
            'cat_nom.string' => 'Nombre de la categoría no válida',
            'cat_obs.required' => 'La descripción de la categoría es requerida',
            'cat_obs.string' => 'Descripción de la categoría no válida'
        ]);

        $category = category::create([
            'cat_nom' => $validateData['cat_nom'],
            'cat_obs' => $validateData['cat_obs']
        ]);

        return response()->json($category, 201);

    }

    public function updateCategory(Request $request, $id){
        $category = category::find($id);

        if(!$category){
            return response()->json(['msg' => 'Categoría no encontrada', 404]);
        }

        $validateData = $request->validate([
            'cat_nom' => 'string|max:255|nullable',
            'cat_obs' => 'string|max:255|nullable'
        ],[
            'cat_nom.string' => 'Nombre de la categoría no válida',
            'cat_obs.string' => 'Descripción de la categoría no válida'
        ]);

        $category->update($validateData);

        return response()->json($category, 200);
    }

    public function deleteCategoryById($id){
        $category = category::find($id);

        if(!$category){
            return response()->json(['msg'=>'Categoría no encontrada'], 404);
        }

        $category->delete();

        return response()->json(['msg'=>'Categoría eliminada correctamente'], 200);
    } 
}
