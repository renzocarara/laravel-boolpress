<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            // creo la colonna 'category_id' all'interno della tabella 'posts' e
            // la inserisco dopo la colonna 'id' con proprietà: NULLABLE
            $table->unsignedBigInteger('category_id')->after('id')->nullable();
            // metto in relazione questa nuova colonna della tabella 'posts' con la colonna 'id'
            // della tabella 'categories' che ho creato precedentemente
            // definisco la colonna 'category_id' in 'posts' come una FOREIGN KEY,
            // poi nei modelli Post e Category andrò a specificare che tipo di relazione c'è,
            // in questo caso la relazione che definirò sarà di tipo '1 a molti', ovvero
            // per '1' categoria ci possono essere associati 'molti' POSTS
            //
            $table->foreign('category_id')->references('id')->on('categories');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            // qui esegue le operazioni "negate" in ordine inverso rispetto
            // a quello che ho fatto nella up(), cioè prima elimino la definizione di Foreign key
            // poi elimino la colonna che avevo creato
            $table->dropForeign('posts_category_id_foreign'); // 'tabella' _ 'nome_colonna' _ 'tipo_di_chiave'
            $table->dropColumn('category_id');

        });
    }
}
