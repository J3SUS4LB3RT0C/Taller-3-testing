<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/Biblioteca.css') }}">

    <script src="https://kit.fontawesome.com/c494e3bce7.js" crossorigin="anonymous"></script>
</head>

<body>
    

    <script>
        document.getElementById('searchButton').addEventListener('click', function() {
            var searchTerm = document.getElementById('searchInput').value.toLowerCase();
            var searchResults = document.getElementById('searchResults');
            var found = false;

            searchResults.innerHTML = '';

            var elements = document.querySelectorAll('#container-to-search [data-searchable]');

            elements.forEach(function(element) {
                var text = element.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    searchResults.appendChild(element.cloneNode(true));
                    found = true;
                }
            });

            if (!found) {
                searchResults.innerHTML = '<p>No se encontraron resultados.</p>';
            }
        });
    </script>

    <nav class="navbar navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('crud.index') }}">
                <img src="images/logo.jpeg" alt="Logo" width="100" height="60"
                    class="d-inline-block align-text-top">
            </a>
            <form action="{{ route('buscar') }}" method="GET">
                @csrf
                <div class="searchBox">
                    <input class="searchInput" type="text" placeholder="Buscar por nombre o autor" name="searchTerm">
                    <button class="searchButton" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29"
                            fill="none">
                            <g clip-path="url(#clip0_2_17)">
                                <g filter="url(#filter0_d_2_17)">
                                    <path
                                        d="M23.7953 23.9182L19.0585 19.1814M19.0585 19.1814C19.8188 18.4211 20.4219 17.5185 20.8333 16.5251C21.2448 15.5318 21.4566 14.4671 21.4566 13.3919C21.4566 12.3167 21.2448 11.252 20.8333 10.2587C20.4219 9.2653 19.8188 8.36271 19.0585 7.60242C18.2982 6.84214 17.3956 6.23905 16.4022 5.82759C15.4089 5.41612 14.3442 5.20435 13.269 5.20435C12.1938 5.20435 11.1291 5.41612 10.1358 5.82759C9.1424 6.23905 8.23981 6.84214 7.47953 7.60242C5.94407 9.13789 5.08145 11.2204 5.08145 13.3919C5.08145 15.5634 5.94407 17.6459 7.47953 19.1814C9.01499 20.7168 11.0975 21.5794 13.269 21.5794C15.4405 21.5794 17.523 20.7168 19.0585 19.1814Z"
                                        stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                                        shape-rendering="crispEdges"></path>
                                </g>
                            </g>
                            <defs>
                                <filter id="filter0_d_2_17" x="-0.418549" y="3.70435" width="29.7139" height="29.7139"
                                    filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                    <feColorMatrix in="SourceAlpha" type="matrix"
                                        values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha">
                                    </feColorMatrix>
                                    <feOffset dy="4"></feOffset>
                                    <feGaussianBlur stdDeviation="2"></feGaussianBlur>
                                    <feComposite in2="hardAlpha" operator="out"></feComposite>
                                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0">
                                    </feColorMatrix>
                                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_2_17">
                                    </feBlend>
                                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2_17"
                                        result="shape"></feBlend>
                                </filter>
                                <clipPath id="clip0_2_17">
                                    <rect width="28.0702" height="28.0702" fill="white"
                                        transform="translate(0.403503 0.526367)"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

    </nav>


    <h1 class="text-center p-1 titulo-libros ">Catalogo de Libros Disponibles y Agregados </h1>

    <center><div><button  data-bs-toggle="modal" data-bs-target="#ModalCrear"><img src="images/agregar.png" alt="agregar"></button></div></center>
    @if (session('correcto'))
        <div class="alert alert-success">{{ session('correcto') }}</div>
    @endif

    @if (session('incorrecto'))
        <div class="alert alert-danger">{{ session('incorrecto') }}</div>
    @endif

    <script>
        var res = function() {
            var not = confirm("¿Estás seguro de eliminar la película?");
            return not;
        };
    </script>

    <div class="modal fade" id="ModalCrear" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar un Libro</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('crud.create') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Libro</label>
                            <input type="text" class="form-control" id="nombre" name="txtnombre">
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción del Libro</label>
                            <input type="text" class="form-control" id="descripcion" name="txtdescripcion">
                        </div>
                        <div class="mb-3">
                            <label for="portada" class="form-label">Portada del Libro</label>
                            <input type="file" class="form-control" id="portada" name="portada">
                        </div>
                        <div class="mb-3">
                            <label for="autor" class="form-label">Autor del Libro</label>
                            <input type="text" class="form-control" id="autor" name="txtautor">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="p-5 table-responsive">

        <div class="p-5 d-flex flex-wrap justify-content-center">
            @foreach ($datos as $item)
                <div class="card m-3" style="width: 240px;">
                    <div class="card-body">
                        <center>
                            @if ($item->portada)
                                <img src="{{ asset('portadas/' . $item->portada) }}" alt="portada"
                                    class="card-img-top" style="max-height: 150px;">
                            @else
                                No tiene imagen Agregada
                            @endif
                        </center>
                        <h5 class="card-title mt-2">{{ $item->nombre }}</h5>
                        <p class="card-text">{{ $item->descripcion }}</p>
                        <p class="card-text"><strong>Elenco:</strong> {{ $item->autor }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <a href="" data-bs-toggle="modal"
                                data-bs-target="#ModalEditar{{ $item->id }}" class="btn btn-sm"><img src="images/editar.png" alt=""></a>
                            <a href="{{ route('crud.delete', $item->id) }}" onclick="return res()"
                                class="btn btn-sm"><img src="images/borrar.png" alt=""></a>
                        </div>

                        <div class="modal fade" id="ModalEditar{{ $item->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modificar datos del
                                            Libro</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('crud.update') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="txtcodigo" class="form-label">Código del
                                                    Libro</label>
                                                <input type="text" class="form-control" id="txtcodigo"
                                                    name="txtcodigo" value="{{ $item->id }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtnombre" class="form-label">Nombre del Libro</label>
                                                <input type="text" class="form-control" id="txtnombre"
                                                    name="txtnombre" value="{{ $item->nombre }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtdescripcion" class="form-label">Descripción del
                                                    Libro</label>
                                                <input type="text" class="form-control" id="txtdescripcion"
                                                    name="txtdescripcion" value="{{ $item->descripcion }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtportada" class="form-label">Portada del
                                                    Libro</label>
                                                <img src="{{ asset('portadas/' . $item->portada) }}"
                                                    alt="portada" style="max-width: 100px;">
                                                <input type="file" class="form-control mt-2" id="txtportada"
                                                    name="portada">
                                            </div>
                                            <div class="mb-3">
                                                <label for="txtautor" class="form-label">Autor del
                                                    Libro</label>
                                                <input type="text" class="form-control" id="txtautor"
                                                    name="txtautor" value="{{ $item->autor }}">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary">Modificar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="{{ $datos->previousPageUrl() }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Anterior</span>
                    </a>
                </li>

                @for ($i = 1; $i <= $datos->lastPage(); $i++)
                    <li class="page-item {{ $i == $datos->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $datos->url($i) }}">{{ $i }}</a>
                    </li>
                @endfor

                <li class="page-item">
                    <a class="page-link" href="{{ $datos->nextPageUrl() }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Siguiente</span>
                    </a>
                </li>
            </ul>
        </nav>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
</body>

</html>