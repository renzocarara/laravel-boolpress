<!-- Bottone che attiva un modal di Bootstrap per la conferma dell'operzione di cancellazione-->
{{-- NOTA IMPORTANTE: per rendere univoco l'id del modal concateno al nome l'id del Post (con la stringa "_{{ $post->id }}") --}}
<button type="button" class="btn btn-danger mt-1" data-toggle="modal" data-target="#deleteConfirmationModal_{{ $post->id }}">
    Elimina
</button>

<!-- Modal per la conferma cancellazione post -->
<div class="modal fade" id="deleteConfirmationModal_{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalTitle_{{ $post->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalTitle_{{ $post->id }}">Cancellazione del Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ATTENZIONE: questa operazione non è reversibile, vuoi veramente cancellare il post?
            </div>
            <div class="modal-footer">

                {{-- bottone per eseguire la cancellazione di un post --}}
                <form class="d-inline" action="{{ route('admin.posts.destroy', ['post' => $post->id]) }}" method="post">
                    @method('DELETE')
                    @csrf
                    <input class="btn btn-danger" type="submit" value="Confermo">
                </form>

                <button type="button" class="btn btn-warning" data-dismiss="modal">Annulla</button>
            </div>
        </div>
    </div>
</div>
