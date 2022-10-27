@extends('layout')

@section('css')

@stop

@section('content')
	<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Presensi</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Presensi</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Data Presensi</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12" style="margin-bottom: 10px;">
              <button class="btn btn-primary" type="button" onclick="tambahPresensi()">Tambah Presensi</button>
              <button class="btn btn-danger" type="button" id="button-hapus-beberapa" onclick="hapusBeberapaPresensi()" disabled>Hapus Presensi</button>
            </div>
            <div class="col-md-12">
              <table class="table table-bordered" id="table2">
                <thead>
                  <tr>
                    <th>
                      <input type="checkbox" id="head-cb2">
                    </th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Masuk</th>
                    <th>Pulang</th>
                    <th>Organisasi</th>
                    <th>Status</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </section>

  <div class="modal fade" id="modal-create">
    <div class="modal-dialog modal-lg">
      <form method="post" id="form-create" action="{{url('presensi')}}" enctype="multipart/form-data" class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Presensi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{csrf_field()}}
          <div class="row">
            <div class="col-md-12">
              <label>Tanggal <small class="text-danger">*</small></label>
              <input wire:model="bulan_tahun" type="date" name="tanggal" class="form-control" max="{{date('Y-m-d')}}" required>
            </div>
            <div class="col-md-12">
              <label>Nama <small class="text-danger">*</small></label>
              <select name="nama" id="nama" class="form-control" required>
                <option value="">Pilih Nama Karyawan</option>
                @foreach($list_karyawan as $kar)
                <option value="{{$kar->nama}}">{{$kar->nama}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-12">
              <label>Masuk <small class="text-danger">*</small></label>
              <!--<input wire:model="jam_masuk" type="time" name="masuk" class="form-control" max="{{date('TH:i:s')}}">-->
              <input type="text" name="masuk" class="form-control" required>
            </div>
            <div class="col-md-12">
              <label>Pulang<small class="text-danger">*</small></label>
              <!--<input wire:model="jam_pulang" type="time" name="pulang" class="form-control" max="{{date('TH:i:s')}}" >-->
              <input type="text" name="pulang" class="form-control" required>
            </div>
            <div class="col-md-12">
            <label>Organisasi</label>
            <input type="text" name="organisasi" id="organisasi" class="form-control" readonly>
            <!--<select name="organisasi" id="organisasi" class="form-control" required>-->
                <!--<option value="">Pilih Organisasi</option>
                @foreach($list_organisasi as $organisasi)
                <option value="{{$organisasi->nama}}">{{$organisasi->nama}}</option>
                @endforeach-->
              </select>
            </div>
            <div class="col-md-12">
            <label>Status</label>
              <select name="status" class="form-control" required>
                <option value="masuk">Masuk</option>
                <option value="belum masuk">Belum Masuk</option>
                <option value="pulang">Pulang</option>
                <option value="alpha">Alpha</option>
                <option value="telat">Telat</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="modal-edit">
    <div class="modal-dialog modal-lg">
      <form method="post" id="form-create" action="{{url('presensi')}}/edit" enctype="multipart/form-data" class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Presensi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{csrf_field()}}
          <input type="hidden" name="id">
          <div class="row">
          <div class="col-md-12">
              <label>Tanggal <small class="text-danger">*</small></label>
              <input wire:model="bulan_tahun" type="date" name="tanggal" class="form-control" max="{{date('Y-m-d')}}" required>
            </div>
            <div class="col-md-12">
              <label>Nama <small class="text-danger">*</small></label>
              <select name="nama" class="form-control" required>
                <option value="">Pilih Nama Karyawan</option>
                @foreach($list_karyawan as $kar)
                <option value="{{$kar->id}}">{{$kar->nama}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-12">
              <label>Masuk <small class="text-danger">*</small></label>
              <!--<input wire:model="jam_masuk" type="time" name="masuk" class="form-control" max="{{date('H:i:s')}}">-->
              <input type="text" name="masuk" class="form-control" required>
            </div>
            <div class="col-md-12">
              <label>Pulang<small class="text-danger">*</small></label>
              <!--<input wire:model="jam_pulang" type="time" name="pulang" class="form-control" max="{{date('H:i:s')}}" >-->
              <input type="text" name="pulang" class="form-control" required>
            </div>
            <div class="col-md-12">
            <label>Organisasi</label>
            <input type="text" name="organisasi" id="organisasi" class="form-control" readonly>
            <!--<select name="organisasi" id="organisasi" class="form-control" required>-->
            </div>
            <div class="col-md-12">
            <label>Status</label>
              <select name="status" class="form-control" required>
                <option value="masuk">Masuk</option>
                <option value="belum masuk">Belum Masuk</option>
                <option value="pulang">Pulang</option>
                <option value="alpha">Alpha</option>
                <option value="telat">Telat</option>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
@stop

@section('js')
<script>
  let list_presensi = [];
  let organisasi = $("#filter-organisasi").val()
  
  const table = $('#table2').DataTable({
    "pageLength": 100,
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'semua']],
    "bLengthChange": true,
    "bFilter": true,
    "bInfo": true,
    "processing":true,
    "bServerSide": true,
    "order": [[ 1, "desc" ]],
    "autoWidth": false,
    "ajax":{
      url: "{{url('')}}/presensi/data",
      type: "POST",
      data:function(d){
        d.organisasi = organisasi;
        return d
      }
    },
    "initComplete": function(settings, json) {
      const all_checkbox_view = $("#row-tampilan div input[type='checkbox']")
      $.each(all_checkbox_view,function(key,checkbox){
        let kolom = $(checkbox).data('kolom')
        let is_checked = checkbox.checked
        table.column(kolom).visible(is_checked)
      })
      setTimeout(function(){
        table.columns.adjust().draw();
      },3000)
    },
    columnDefs: [
      {
        "targets": 0,
        "class":"text-nowrap",
        "sortable":false,
        "render": function(data, type, row, meta){
          return `<input type="checkbox" class="cb-child2" value="${row.id}">`;
        }
      },
      {
        "targets": 1,
        "class":"text-nowrap",
        "render": function(data, type, row, meta){
          list_presensi[row.id] = row;
          return row.tanggal;
        }
      },
      {
        "targets": 2,
        "class":"text-nowrap",
        "render": function(data, type, row, meta){
          return row.nama;
        }
      },
      {
        "targets": 3,
        "class":"text-nowrap",
        "render": function(data, type, row, meta){
          return row.masuk;
        }
      },
      {
        "targets": 4,
        "class":"text-nowrap",
        "render": function(data, type, row, meta){
          return row.pulang;
        }
      },
      {
        "targets": 5,
        "class":"text-nowrap",
        "render": function(data, type, row, meta){
          return row.organisasi;
        }
      },
      {
        "targets": 6,
        "class":"text-nowrap",
        "render": function(data, type, row, meta){
          return row.status;
        }
      },
      
      {
        "targets": 7,
        "sortable":false,
        "render": function(data, type, row, meta){
          let tampilan = /*`
            <button class="btn btn-warning" type="button" onclick="editPresensi(${row.id})">Edit</button>
          `*/ '';
          if(!row.id){
            tampilan+=`<button class="btn btn-danger" type="button" onclick="hapus(${row.id})">Hapus</button>`
          }
          return tampilan
        }
      }
      
    ]
  });

  function tambahPresensi() {
    $("#modal-create").modal('show')
  }

  /*$("#organisasi").on('change',function(){
    let namaOption = document.getElementById('nama').value;
    $.ajax({
          url:"{{url('')}}/presensi/getOrganisasi/"+namaOption,
          success:function(res){
            if(res){
              table.ajax.reload(null,false)
            }else{
              alert("Terjadi kesalahan")
            }
          }
        })
  })*/

  /*$("#nama").on('change',function(e){
    let nama = e.target.value;
    $.ajax({
      url:"{{url('')}}/karyawan/getOrganisasi/"+nama,
      success:function (res) {
        $('#organisasi').empty();
        $.each(res.dataNama[0].dataNama,function(index,organisasi){
          $('#organisasi').append('<option value="'+organisasi.id+'">'+organisasi.name+'</option>');
        })
      }
    })
  })*/

  $("#nama").change(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    const langId = $(this).val();
    console.log("langid", langId);

    $.ajax({
        type: "POST",
        url: "organisasis",
        data: {
            org_id: langId,
        },
        success: function (result) {
            $("#organisasi").empty();

            if (result && result?.status === "success") {
                result?.data?.map((organisasi) => {
                    $("#organisasi").val(organisasi.nama);
                });
            }
        },
        error: function (result) {
            console.log("error", result);
        },
    });
});

  $("#modal-create form").on('submit',function(e){
    e.preventDefault()
    $(this).ajaxSubmit({
      success:function(res){
        table.ajax.reload(null,false)
        $("#modal-create").modal('hide')
        //$("#modal-create input").val('')
        $("#modal-create input:not([name='_token'])").val('')
        //$("#modal-create input[name='password']").val('12345')
      }
    })
  })

  $("#modal-edit form").on('submit',function(e){
    e.preventDefault()
    $(this).ajaxSubmit({
      success:function(res){
        table.ajax.reload(null,false)
        $("#modal-edit").modal('hide')
        $("#modal-edit input").val('')
      }
    })
  })

  function hapus(id) {
    const presensi = list_presensi[id]
    if(user){
      const _c = confirm('apakah anda yakin akan menghapus data '+presensi.nama+' ?')
      if(_c===true){
        $.ajax({
          url:"{{url('')}}/presensi/delete/"+id,
          success:function(res){
            if(res){
              table.ajax.reload(null,false)
            }else{
              alert("Terjadi kesalahan")
            }
          }
        })
      }
    }
  }

  function editPresensi(id) {
    const presensi = list_presensi[id]
    $("#modal-edit input[name='tanggal']").val(presensi.tanggal)
    $("#modal-edit input[name='nama']").val(presensi.nama)
    $("#modal-edit input[name='masuk']").val(presensi.masuk)
    $("#modal-edit input[name='pulang']").val(presensi.pulang)
    $("#modal-edit input[name='organisasi']").val(presensi.organisasi)
    $("#modal-edit input[name='status']").val(presensi.status)
    $("#modal-edit input[name='id']").val(id)
    $("#modal-edit").modal('show')
  }

  $(".filter").on('change',function(){
    organisasi = $("#filter-organisasi").val()
    table.ajax.reload(null,false)
  })

  $("#head-cb2").on('click',function(){
    var isChecked = $("#head-cb2").prop('checked')
    $(".cb-child2").prop('checked',isChecked)
    $("#button-hapus-beberapa").prop('disabled',!isChecked)
  })

  $("#table2 tbody").on('click','.cb-child2',function(){
    if($(this).prop('checked')!=true){
      $("#head-cb2").prop('checked',false)
    }

    let semua_checkbox = $("#table2 tbody .cb-child2:checked")
    let button_hapus_terpilih = (semua_checkbox.length>0)
    $("#button-hapus-beberapa").prop('disabled',!button_hapus_terpilih)
  })

  function hapusBeberapaPresensi() {
    const _c = confirm("Anda yakin akan menghapus presensi tersebut ?")
    if(_c===true){
      let semua_id = []
      let checkbox_terpilih = $("#table2 tbody .cb-child2:checked")
      $.each(checkbox_terpilih,function(index,elm){
        semua_id.push(elm.value)
      })
      $.ajax({
        url:"{{url('')}}/presensi/hapus_beberapa",
        method:'post',
        data:{ids:semua_id},
        success:function(res){
          table.ajax.reload(null,false)
          $("#button-hapus-beberapa").prop('disabled',true)
          $("#head-cb2").prop('checked',false)
        }
      })
    }
    
  }

  function nonAktifkanTerpilih () {
    
    let semua_id = []
    $.each(checkbox_terpilih,function(index,elm){
      semua_id.push(elm.value)
    })
    $("#button-hapus-beberapa").prop('disabled',true)
    $.ajax({
      url:"{{url('')}}/presensi/non-aktifkan",
      method:'post',
      data:{ids:semua_id},
      success:function(res){
        table.ajax.reload(null,false)
        $("#button-nonaktif-all").prop('disabled',false)
        $("#head-cb2").prop('checked',false)
      }
    })
  }
</script>
@stop