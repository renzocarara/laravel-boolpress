<?php

use Illuminate\Database\Seeder;
// aggiungo il modello su cui devo lavorare
use App\Tag;


class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // leggo il file 'tags.php' dove c'e un array con chiave 'tag_db'
        $tags = config('tags.tag_db');
        // ciclo i dati letti dal file
        foreach ($tags as $tag) {
            // creo un nuovo oggetto di tipo Tag
            $new_tag = new Tag();
            // ci assegno i dati che ho messo in '$tags', letti dal file tag.php, cioè l'array con chiave 'tag_db'
            $new_tag->name = $tag['name'];
            $new_tag->slug = $tag['slug'];
            // in alternativa posso usare la fill(), avendo dichiarato le colonne 'name' e 'slug' come fillabili
            // all'interno del model Tag.php
            // $new_tag->fill($tag);

            // salvo l'oggetto nel DB
            $new_tag->save();
        }
    }
}
