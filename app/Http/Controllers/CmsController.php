<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function contact(){

        $contacts = Contact::all();
        return response()-> json ([
            'contacts' => $contacts
        ], 200);
    }
    public function addMap(Request $request){
        $data = $request->validate([
            'map_url' => 'required'
        ]);
        $contact = Contact::create($data);
        return response()-> json(['contact' => $contact], 200);
    }
    public function editMap($id){
        if (Contact::where('id', $id)->exists()) {
            $contact = Contact::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($contact, 200);
          } else {
            return response()->json([
              "message" => "Contact map not found",
            ], 404);
        }
    }

    public function updateMap(Request $request, $id){
        if (Contact::where('id', $id)->exists()) {
            $contact = Contact::findOrFail($id);
            $contact->update($request->all());

            return response()->json([
                "message" => "Contact map updated successfully",
            ], 200);
            } else {
            return response()->json([
                "message" => "Contact map not found",
            ], 404);

        }
    }

}
