@extends('layouts.app')
@section('title')
Edition Compagnie
@endsection
@section('content')
<div class="pagetitle">
  <h1>Edition d'une Compagnie</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('accueil_index')}}">Accueil</a></li>
      <li class="breadcrumb-item active">Compagnie</li>
    </ol>
  </nav>
</div><!-- End Page Title -->
<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <form action="{{route('company_update')}}" method="post" class="row g-3" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <input type="hidden" name="id" value="{{$compagnie->id}}">
            <div class="col-6">
              <label for="nom" class="form-label">Nom</label>
              <input type="text" class="form-control" id="nom" name="nom" value="{{$compagnie->nom}}" required>
            </div>
            <div class="col-6">
              <label for="code" class="form-label">Code</label>
              <input type="text" class="form-control" id="code" name="code" value="{{$compagnie->code}}">
            </div>
            <div class="col-3">
              <label for="logo" class="form-label">Logo Actuel</label>
              <img src="{{asset('images/logo/'.$compagnie->logo)}}" style="max-height: 200px" alt="logo-{{$compagnie->nom}}">
            </div>
            <div class="col-3">
              <label for="logo" class="form-label">Nouveau Logo</label>
              <input type="file" class="form-control" name="logo" id="logo" accept="image/*">
            </div>
            <div class="col-6">
              <label for="idType" class="form-label">Type</label>
              <select name="idType" class="form-control" id="idType">
                  <option selected=""  value="">Sélectionnez le type</option>
                  @foreach ($typedatas as $item)
                    @if ($item->id==$compagnie->idType)
                      <option selected="" value="{{$item->id}}">{{$item->label}}</option>
                    @else
                      <option value="{{$item->id}}">{{$item->label}}</option>
                    @endif
                  @endforeach
              </select>
            </div>
              <div class="col-12">
                <a href="{{route('company_index')}}" class="btn btn-warning" >Annuler</a>
                <button type="submit" class="btn btn-success">Modifier</button>
              </div>
            </form>
        </div>
      </div>

    </div>
  </div>

  {{-- Modal --}}
  <div class="row">
    <div class="col-lg-6">

      <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Ajout Type Compagnie</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('company_store')}}" method="post" class="row g-3">
              @csrf
              <div class="modal-body">
                <div class="col-12">
                  <label for="label" class="form-label">Nom</label>
                  <input type="text" class="form-control" id="label" name="label" required>
                </div>
                <div class="col-12">
                  <label for="description" class="form-label">Description</label>
                  <textarea name="description" id="description" class="form-control"  required></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <a href="" class="btn btn-danger" data-bs-dismiss="modal">Annuler</a>
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
            </form>
            
          </div>
        </div>
      </div>
      
    </div>
  </div>
</section>
@endsection