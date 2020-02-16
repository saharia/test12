<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'artist_id',
        'release_date'
    ];


  public function AlbumSong()
  {
    return $this->hasMany('App\AlbumSong', 'album_id');
  }

  public function Artist()
  {
    return $this->belongsTo('App\Artist', 'artist_id');
  }
}
