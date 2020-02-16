<?php

namespace App\Http\Controllers\Api;
use App\Artist;
use App\Album;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
class ArtistController extends Controller
{

  public function getAll()
    {
      $artists = Artist::all();

      return response([ 'artists' => $artists ]);
    }

    public function save(Request $request)
    {
       $validated_data = $request->validate([
        "name" => "required|max:55",
      ]);
      $artist = Artist::create($validated_data);

      return response([ 'artist' => $artist ]);
    }

    public function delete($id)
    {
      $artists = Album::where([ 'artist_id' => $id ])->count();
      if($artists) {
        return response()->json([ 'msg' => 'Some album have this artists' ], 403);
      }
      $artist = Artist::find($id)->delete();

      return response([ 'artist' => $artist ]);
    }
    public function update(Request $request, $id)
    {
      $artist = Artist::find($id);
       $validated_data = $request->validate([
        "name" => "required|max:55",
      ]);
      $artist->name = $request->name;
      $artist->save();

      return response([ 'artist' => $artist ]);

    }
}
