<?php

namespace App\Http\Controllers\Api;
use App\Song;
use App\AlbumSong;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
class SongController extends Controller
{
    public function getAll()
    {
      $songs = Song::all();

      return response([ 'songs' => $songs ]);
    }

    public function save(Request $request)
    {
       $validated_data = $request->validate([
        "name" => "required|max:55",
        "track_time" => "required"
      ]);
       $file_name = '';
       if($request->hasFile('file_name'))
        {
       $file = $request->file('file_name');
       $path = Storage::putFile('images', $file);
       $file_name = basename($path);
     }
       $data = [
        'name' => $request->name,
        'track_time' => $request->track_time,
        'file_name' => $file_name
       ];
      $song = Song::create($data);

      return response([ 'song' => $song ]);
    }

    public function delete($id)
    {
      $album_song = AlbumSong::where([ 'song_id' => $id ])->count();
      if($album_song) {
        return response()->json([ 'msg' => 'Some album have this songs' ], 403);
      }
      $song = Song::find($id)->delete();

      return response([ 'song' => $song ]);
    }
    public function update(Request $request, $id)
    {
      $song = Song::find($id);
       $validated_data = $request->validate([
        "name" => "required|max:55",
        "track_time" => "required"
      ]);
       $file_name = '';
       if($request->hasFile('file_name'))
        {
       $file = $request->file('file_name');
       $path = Storage::putFile('images', $file);
       $file_name = basename($path);
     }
       $data = [
        'name' => $request->name,
        'track_time' => $request->track_time,
        'file_name' => $file_name
       ];
      foreach ($data as $key => $value) {
        $song->{$key} = $value;
      }

      $song->save();

      return response([ 'song' => $song ]);
    }
}
