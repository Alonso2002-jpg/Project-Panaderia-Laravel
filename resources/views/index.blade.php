@extends('main')

@section('title', 'Miga de Oro - Home')

@section('content')
<div>
    <div id="cabecera">
        <div id="medio">
            <img src="{{ asset('/images/logo.png') }}" width="300px">
        </div>
    </div>
<section>
        <br>
        <div class="container mt-3">
            <div class="row">
                <div class="col">
                    <div class="card" style="width:400px">
                        <img class="card-img-top" src="{{ asset('/images/perfil.jpg') }}" alt="Card image" style="width:100%">
                        <div class="card-body">
                            <h4 class="card-title">¡Conviertete en nuestro usuario estrella!</h4>
                            <p class="card-text">¡Subscribite a nuestra pagina web para recibir notificaciones de las noticias dentro de nuestra pagina web para siempre estar atento/a a las nuevos productos de la Panadería!</p>
                            <a href="login.html" class="btn btn-secondary">Iniciar sesion o Registrarse</a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card" style="width:800px">
                        <div class="card-body">
                            <h4 class="card-title">Título de la segunda tarjeta</h4>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur deleniti cupiditate magni rem pariatur magnam, id fugit ad excepturi corrupti aut quod nulla repellat iure saepe. Expedita vitae nam non! Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati eaque est incidunt facere, totam quod! Non, eum pariatur tempora deleniti, corrupti voluptatibus, debitis quisquam ad perferendis sequi laboriosam dicta perspiciatis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta excepturi dignissimos numquam architecto a dolore consectetur laudantium, aut sequi totam! Eius modi aut optio tempora voluptate enim sequi. Repudiandae, laudantium.</p>
                            <a href="#" class="btn btn-secondary">Ver más</a>
                        </div>
                    </div>
                    <br>
                    <div class="col">
                        <div class="card" style="width:800px">
                            <div class="card-body">
                                <h4 class="card-title">Título de la tercera tarjeta</h4>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur deleniti cupiditate magni rem pariatur magnam, id fugit ad excepturi corrupti aut quod nulla repellat iure saepe. Expedita vitae nam non! Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati eaque est incidunt facere, totam quod! Non, eum pariatur tempora deleniti, corrupti voluptatibus, debitis quisquam ad perferendis sequi laboriosam dicta perspiciatis. Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta excepturi dignissimos numquam architecto a dolore consectetur laudantium, aut sequi totam! Eius modi aut optio tempora voluptate enim sequi. Repudiandae, laudantium.</p>
                                <a href="#" class="btn btn-secondary">Ver más</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
</div>
@endsection
