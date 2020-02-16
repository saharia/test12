<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlbumSong extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'album_id',
        'song_id',
    ];

  public function Song()
  {
    return $this->belongsTo('App\Song');
  }
}
