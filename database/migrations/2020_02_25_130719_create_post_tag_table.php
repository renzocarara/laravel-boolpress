<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // la tabella post_tag è una tabella 'ponte' tra le tabelle tags e posts.
        // Non serve abbia una sua colonna id.
        // C'è una relazione 'molti a molti' tra le tabelle tags e posts, in particolare tramite gli 'id'
        // di queste 2 tabelle viene esplicitata la relazione.
        // In questa tabella tag_post ho 2 colonne tag_id e post_id che conterrano gli id
        // che vengono messi in relazione

        Schema::create('post_tag', function (Blueprint $table) {
            $table->bigInteger('post_id')->unsigned(); // colonna che conterrà id di post
            $table->bigInteger('tag_id')->unsigned(); // colonna che conterrà id dei tag
            // dichiaro che la chiave (colonna) 'post_id' è una FOREIGN KEY (chiave esterna),
            // che fa riferimento alla colonna 'id' della tabella 'posts'
            $table->foreign('post_id')->references('id')->on('posts');
            // dichiaro che la chiave (colonna) 'tag_id' è una FOREIGN KEY (chiave esterna),
            // che fa riferimento alla colonna 'id' della tabella 'tags'
            $table->foreign('tag_id')->references('id')->on('tags');
            // dichiaro che la combinazione delle 2 colonne 'post_id' e 'tag_id' formano una chiave primaria
            $table->primary(['post_id', 'tag_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_tag');
    }
}
