@extends('layouts.app')
@section('title')
Comptes
@endsection
@section('content')
<div class="pagetitle">
  <h1>Liste de mes comptes bancaires</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Accueil</a></li>
      <li class="breadcrumb-item active">Comptes bancaires</li>
    </ol>
  </nav>
</div><!-- End Page Title -->
<div class="border-0 mb-3">
  <div class="row g-4">
      <div class="col-sm">
          <div class="d-flex justify-content-sm-end mb-2">
              <div class="search-box ms-2">
                  <a class="btn btn-success" id="addbutton" data-bs-toggle="modal" id="create-btn" data-bs-target="#addModal"><i class="ri-add-line align-bottom me-1"></i> Ajouter</a>
              </div>
          </div>
      </div>
  </div>
</div>
<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          {{-- <h5 class="card-title">Datatables</h5>
          <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable. Check for <a href="https://fiduswriter.github.io/simple-datatables/demos/" target="_blank">more examples</a>.</p> --}}

          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th>Numéro</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Statut</th>
                <th>Solde</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($bankAccounts as $item)
                <tr>
                  <td>{{$item->number}}</td>
                  <td>{{$item->name}}</td>
                  <td>{{$item->firstname}}</td>
                  <td>
                    @if ($item->statut)
                    <span class="badge bg-success">Actif</span>
                    @else
                    <span class="badge bg-danger">Désactivé</span>
                    @endif
                    
                  </td>
                  <td>{{$item->balance}}</td>
                  <td>
                    <div class="filter">
                      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        @if ($item->statut)
                            <li><a href="" id="depotBtn" class="dropdown-item" data-id="{{$item->id}}" data-bs-toggle="modal" data-bs-target="#depotModal">Faire Dépot</a></li>
                            <li><a href="" id="retraitBtn" class="dropdown-item" data-id="{{$item->id}}" data-bs-toggle="modal" data-bs-target="#retraitModal">Faire Retrait</a></li>
                        @endif
                        {{-- <li><a class="dropdown-item" href="{{route('company_edit',['id'=>$item->id])}}">Modifier</a></li> --}}
                        
                      </ul>
                    </div>
                  </td>
                </tr>
            @empty
                <tr>
                  <td colspan="6" class="text-center">Aucune information trouvée</td>
                </tr>
            @endforelse
            </tbody>
          </table>
          <!-- End Table with stripped rows -->

        </div>
      </div>

    </div>
  </div>

  {{-- Modal Ajout--}}
  <div class="row">
    <div class="col-lg-6">

      <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Ajout Compte</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('account')}}" method="post" class="row g-3" enctype="multipart/form-data">
              @csrf
              <div class="modal-body">
                <div class="col-12">
                  <label for="name" class="form-label">Nom</label>
                  <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="col-12">
                  <label for="firstname" class="form-label">Prenom</label>
                  <input type="text" class="form-control" id="firstname" name="firstname">
                </div>
              </div>
              <div class="modal-footer">
                <a href="" class="btn btn-warning" data-bs-dismiss="modal">Annuler</a>
                <button type="submit" class="btn btn-success">Ajouter</button>
            </div>
            </form>
            
          </div>
        </div>
      </div>

      <div class="modal fade" id="depotModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Dépot</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('deposit')}}" method="post" class="row g-3" enctype="multipart/form-data">
              <input type="hidden" name="id" id="depotId">
              @csrf
              <div class="modal-body">
                <div class="col-12">
                  <div class="col-12">
                    <label for="amount" class="form-label">Montant</label>
                    <input type="number" class="form-control" id="amount" name="amount" required>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <a href="" class="btn btn-warning" data-bs-dismiss="modal">Annuler</a>
                <button type="submit" class="btn btn-success">Déposer</button>
            </div>
            </form>
            
          </div>
        </div>
      </div>

      <div class="modal fade" id="retraitModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Dépot</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('withdrawal')}}" method="post" class="row g-3" enctype="multipart/form-data">
              <input type="hidden" name="id" id="retraitId">
              @csrf
              <div class="modal-body">
                <div class="col-12">
                  <label for="amount" class="form-label">Montant</label>
                  <input type="number" class="form-control" id="amount" name="amount" required>
                </div>
              </div>
              <div class="modal-footer">
                <a href="" class="btn btn-warning" data-bs-dismiss="modal">Annuler</a>
                <button type="submit" class="btn btn-success">Retirer</button>
            </div>
            </form>
            
          </div>
        </div>
      </div>
      
    </div>
  </div>
</section>
@endsection