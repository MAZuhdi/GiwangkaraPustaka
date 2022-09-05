<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Books Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table id="tablebooks" class="table table-hover text-wrap">
                    <thead>
                        <tr>
                        <th>Kode Panggil</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Tahun</th>
                        <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        @foreach ($books as $book)
                        <tr>
                            <!-- <td>{{$i++}}</td> -->
                            <td>{{$book->kode_panggil}}</td>
                            <td>{{$book->judul}}</td>
                            <td>{{$book->penulis}}</td>
                            <td>{{$book->tahun_terbit}}</td>
                            <td>
                                <a href="/user/{{$book->kode}}/edit" class="btn btn-sm btn-warning"><i class="fa fa-cog fa-inverse"></i></a>
                                <a data-id="{{$book->kode}}" data-toggle="modal" data-target="#exampleModal" class="btn btn-sm btn-data btn-danger "><i class="fa fa-trash fa-inverse"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table >
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">HAPUS</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Anda Yakin Ingin Menghapus?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger btn-hapus">Hapus</button>
        </div>
      </div>
    </div>
</div>


<script>
$(document).on('click', '.btn-data', function (e) {
    let id = $(this).attr('data-id');
    console.log(id);
    $(document).on('click', '.btn-hapus', function (e) {
       console.log(id);
        $.ajax({
            url : "{{url('/')}}/api/books/"+id,
            method : "POST",
            data : {
                _token : "{{csrf_token()}}",
                _method : "DELETE",
            }
        })
        .then(function(data){
            location.reload();
        });
    });
});
</script>