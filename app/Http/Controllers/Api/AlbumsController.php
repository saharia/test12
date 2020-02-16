<?php

namespace App\Http\Controllers\Api;
use App\Album;
use App\AlbumSong;
use App\Artist;
use App\Song;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
class AlbumsController extends Controller
{

  public function getAll()
    {
      $albums = Album::with(['AlbumSong.Song', 'Artist'])->get();
      $artists = Artist::all();
      $songs = Song::all();
      return response([ 'albums' => $albums, 'artists' => $artists, 'songs' => $songs ]);
    }

    public function save(Request $request)
    {
       $validated_data = $request->validate([
        "name" => "required|max:55",
        "artist_id" => "required",
        'release_date' => 'required'
      ]);
      $album = Album::create($validated_data);
      $album_song = [];
      foreach ($request->songs as $song_id) {
        $album_song[] = [ 'album_id' => $album->id, 'song_id' => $song_id ];
      }
      if(count($album_song)) {
        AlbumSong::insert($album_song);
      }
      $album = Album::with('AlbumSong.Song')->where([ 'id' => $album->id ])->first();
      return response([ 'album' => $album ]);
    }

    public function delete($id)
    {
      $album = Album::find($id)->delete();

      return response([ 'album' => $album ]);
    }
    public function update(Request $request, $id)
    {
      $album = Album::find($id);
       $validated_data = $request->validate([
        "name" => "required|max:55",
        "artist_id" => "required",
        'release_date' => 'required'
      ]);
      $album->name = $request->name;
      $album->artist_id = $request->artist_id;
      $album->release_date = $request->release_date;
      $album->save();


      AlbumSong::where([ 'album_id' => $id ])->delete();
      $album_song = [];
      foreach ($request->songs as $song_id) {
        $album_song[] = [ 'album_id' => $id, 'song_id' => $song_id ];
      }
      if(count($album_song)) {
        AlbumSong::insert($album_song);
      }

      return response([ 'album' => $album ]);

    }
}
