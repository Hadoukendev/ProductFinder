@extends('templates.default')


@section('header')


  <meta property="og:url"           content="{{$producto['enlace']}}" />
  <meta property="og:type"          content="website" />
  <meta property="og:title"         content="{{$producto['nombre']}}" />
  <meta property="og:description"   content="{{$producto['descripcion']}}" />
  <meta property="og:image"         content="{{$producto['imagen']}}" />




@endsection
@section('pagecontent')
@php
$items=Cart::content();
@endphp



 <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
<div class="container-fluid">
  <div class="row" style="border-bottom: 5px solid #C42854;">
          <div class="col-md-4">
            <nav class="navbar navbar-default navbar-static" style="background: transparent; border: 0; margin-top: 1rem;">
              <div class="navbar-header">
              <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              
            </div>

            <div class="collapse navbar-collapse js-navbar-collapse">
              
              <ul class="nav navbar-nav" style="width:100%">
                <li class="dropdown dropdown-large" style="width:100%">
                   <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #777777;"><i class="fa fa-bars prefix"></i> Categorías <b class="caret"></b></a>

                  <?php
                  $arraycat=array();
                  $arrayslug=array();
                  foreach($categorias as $categoria){
                     
                      $arraycat[]=$categoria->nombre;
                      $arrayslug[]=$categoria->slug;
                    
                  }

                   ?>
                  <ul class="dropdown-menu dropdown-menu-large row">
                    @for ($i=0; $i < 4 ; $i++)
                    <li class="col-sm-3">
                      <ul>
                        <!--li class="dropdown-header">Glyphicons</li-->
                        @for ($x=$i*5; $x < ($i+1)*5 ; $x++)
                        <li style="width: 100%;"><a href="{{url('/buscar/')}}/{{$arrayslug[$x] or ''}}">{{$arraycat[$x] or ''}}</a></li>
                        @endfor
                      </ul>
                    </li>
                    @endfor
                  </ul>
                  
                </li>
              </ul>
            


              


              
            </div><!-- /.nav-collapse -->
          </nav>
        </div>

        <div class="col-md-4">
                <form action="{{url('/buscar')}}" method="post" style="width: 100%;">
                  {{ csrf_field() }}

                  <div class="input-field valign-wrapper">
                    <i class="fa fa-search prefix"></i>
                    <input id="buscador" name="busqueda" type="text" value="{{$busqueda or ''}}" placeholder="Busca otro producto" class="validate" style="    border-bottom: 1px solid #9e9e9e;">
                  </div>
                  </form>
                </div>

                <div class="col-md-4" style="padding-top: 2rem;">
                  <a href="{{url('/favoritos')}}" style="color: #777777; width: 100%; display: block; text-decoration: none;"><i class="fa fa-heart"></i> Favoritos</a>
                  

                </div>
      </div>
</div>
<?php $esfav=false;?>
@php
  $nombre = $producto['nombre'];
  $enlace = $producto['enlace'];
  $precio = $producto['precio'];
  $imagen = $producto['imagen'];
  $tienda = $producto['tienda'];
  $url = $producto['enlacetienda']
@endphp
      <div class="container">
        <div class="row">

          <div class="col-md-12">

                  <div class="row-fluid">
                   <div class="col-md-5">
                     <img src="{{$producto['imagen']}}" class="img-responsive" alt="">
                   </div> 
                   <div class="col-md-7">
                    <div class="favorito">
                          @foreach ($items as $product)
                             @if($product->name==$nombre)
                              <?php $esfav=true;
                              $productid=$product->rowId;
                               break; ?>
                             @else
                              <?php $esfav=false; $productid=""; ?>
                             @endif         
                          @endforeach
                          <a class="favp0" onclick="addtofavorite('{{$nombre}}','{{$enlace}}','{{$precio}}','{{$imagen}}','{{$tienda}}','{{$url}}', 'favp')" style=" cursor: pointer;">
                            <i class="fa fa-heart-o fa-2x" aria-hidden="true"></i>
                          </a>
                         
                          <a class="favp1" style="display: none; cursor: pointer;">
                            <i class="fa fa-heart fa-2x " aria-hidden="true"></i>
                          </a>

                          @if($esfav)
                            <script>
                                $('.favp'+"0").hide();
                                $('.favp'+"1").show();
                                $(document).ready(function(){
                                  $( ".favp1" ).click(function() {
                                    removefromfavorite('{{$productid}}','favp');
                                  });
                                });
                            </script>
                          @else
                          <script>
                                $('.favp'+"1").hide();
                                $('.favp'+"0").show();


                            </script>
                            
                            <div id="favp">
                              
                            </div>
                            </script>

                          @endif

                          
                              
                        </div>


                     <h4>{{$producto['nombre']}}</h4>
                     <div class="pricefrom">
                        <p>lo encuentras desde</p>
                        <div class="price">$  {!!number_format($producto['precio']/100, 2, '.', ',')!!}</div>
                      </div>
                     <p>{{$producto['descripcion']}}</p>
                     <a href="{{$producto['enlacetienda']}}" target="_blank">
                        <div class="from">
                          <p>{{$producto['tienda']}}</p>
                        </div>
                      </a>
                     <div class="buttons">
                       <a href="{{$producto['enlace']}}" target="_blank" class="btn btn-primary">Comprar</a>
                       <div id="shareBtn" class="btn btn-success clearfix" style="background-color: #3B5999;"><i class="fa fa-facebook" aria-hidden="true"></i> Compartir</div>
                     </div>

                   </div>
                  </div><!--/row-fluid-->
          </div>
        </div>


</div>



      <p>&nbsp;</p>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <h5 style="margin: 0;">También te puede interesar</h5>
            <hr>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="relacionados">
              <?php $relacionadocount=0; $esfav=false;?>
              @foreach($relacionados as $producto)

                    <div class="col-md-2 col-sm-4 col-xs-6">
                      <form action="{{url('/producto')}}" method="post" id="tendencia{{$relacionadocount}}" style="display: none;">
                        {{ csrf_field() }}
                        @php
                          $nombre = $producto['nombre'];
                          $enlace = $producto['enlace'];
                          $precio = $producto['precio'];
                          $imagen = $producto['imagen'];
                          $tienda = $producto['tienda'];
                          $url = $producto['enlacetienda']
                        @endphp
                        <input type="hidden" name="nombre" value="{{$nombre}}">
                        <input type="hidden" name="enlace" value="{{$enlace}}">
                        <input type="hidden" name="precio" value="{{$precio}}">
                        <input type="hidden" name="imagen" value="{{$imagen}}">
                        <input type="hidden" name="tienda" value="{{$tienda}}">
                        <input type="hidden" name="url" value="{{$url}}">
                      </form>
                      <div class="product-small">
                        <div class="favorito">
                          @foreach ($items as $product)
                             @if($product->name==$nombre)
                              <?php $esfav=true;
                              $productid=$product->rowId;
                               break; ?>
                             @else
                              <?php $esfav=false; $productid=""; ?>
                             @endif         
                          @endforeach
                          <a class="fav{{$relacionadocount}}0" onclick="addtofavorite('{{$nombre}}','{{$enlace}}','{{$precio}}','{{$imagen}}','{{$tienda}}','{{$url}}', 'fav{{$relacionadocount}}')">
                            <i class="fa fa-heart-o fa-lg" aria-hidden="true"></i>
                          </a>
                         
                          <a class="fav{{$relacionadocount}}1" style="display: none;">
                            <i class="fa fa-heart fa-lg " aria-hidden="true"></i>
                          </a>

                          @if($esfav)
                            <script>
                                $('.fav'+'{{$relacionadocount}}'+"0").hide();
                                $('.fav'+'{{$relacionadocount}}'+"1").show();
                                $(document).ready(function(){
                                  $( ".fav{{$relacionadocount}}1" ).click(function() {
                                    removefromfavorite('{{$productid}}','fav{{$relacionadocount}}');
                                  });
                                });
                            </script>
                          @else
                          <script>
                                $('.fav'+'{{$relacionadocount}}'+"1").hide();
                                $('.fav'+'{{$relacionadocount}}'+"0").show();


                            </script>
                            
                            <div id="fav{{$relacionadocount}}">
                              
                            </div>
                            </script>

                          @endif

                          
                              
                        </div>
                        <a style="cursor: pointer;" onclick="document.getElementById('tendencia{{$relacionadocount}}').submit()">
                          <div class="img-container text-center">
                            
                            <img src="{{$producto['imagen']}}" alt="" style="max-width: 100%; margin: 0 auto;">
                            <div class="ver-producto">
                              <p>Ver producto <i class="fa fa-search" aria-hidden="true"></i></p>
                            </div>
                          </div>
                          <div class="name">
                            <b>{{str_limit($producto['nombre'], $limit = 22, $end = '...')}}</b>
                          </div>
                          <div class="pricefrom">
                            <div class="price">$  {!!number_format($producto['precio']/100, 2, '.', ',')!!}</div>
                          </div>
                          
                        </a>
                        <a href="{{$producto['enlacetienda']}}" target="_blank">
                          <div class="from">
                            <p>{{$producto['tienda']}}</p>
                          </div>
                        </a>
                      </div>
                    </div>
                    
                    <?php $relacionadocount++;?>
              @endforeach
            </div>
    


          </div>
        </div>
</div>




       

      




      <div class="container-fluid info">
        <div class="row">
          <div class="col-md-3 info-item">
            <div class="text-center">
              <i class="fa fa-tags fa-3x"></i>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus reprehenderit inventore qui molestias perspiciatis, animi? Nisi eum repellat ad in aspernatur ullam voluptas voluptates deserunt quod totam, modi, dolorum. Reiciendis?</p>
          </div>
            <div class="col-md-3 info-item">
            <div class="text-center">
              <i class="fa fa-comment fa-3x"></i>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus reprehenderit inventore qui molestias perspiciatis, animi? Nisi eum repellat ad in aspernatur ullam voluptas voluptates deserunt quod totam, modi, dolorum. Reiciendis?</p>
          </div>
          <div class="col-md-3 info-item">
            <div class="text-center">
              <i class="fa fa-certificate fa-3x"></i>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus reprehenderit inventore qui molestias perspiciatis, animi? Nisi eum repellat ad in aspernatur ullam voluptas voluptates deserunt quod totam, modi, dolorum. Reiciendis?</p>
          </div>
          <div class="col-md-3 info-item">
            <div class="text-center">
              <i class="fa fa-trophy fa-3x"></i>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatibus reprehenderit inventore qui molestias perspiciatis, animi? Nisi eum repellat ad in aspernatur ullam voluptas voluptates deserunt quod totam, modi, dolorum. Reiciendis?</p>
          </div>
        </div>
            
          
      </div>


@endsection


@section('scripts')



<script>
  
  $(document).ready(function(){
    $('.relacionados').slick({
  slidesToShow: 6,
  slidesToScroll: 1,
  autoplay: false,
  arrows: true,
  autoplaySpeed: 2000,
   responsive: [
    {
      breakpoint: 768,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 3
      }
    },
    {
      breakpoint: 480,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '40px',
        slidesToShow: 1
      }
    }
  ]
});
});

</script>

<script>
  document.getElementById('shareBtn').onclick = function() {
    FB.ui({
      method: 'share',
      display: 'popup',
      href: "{{$producto['enlace']}}",
    }, function(response){

    });
  }
</script>




<script>
function addtofavorite(nombre,enlace,precio,imagen,tienda,url,id){
    _token = $('#token').val();
    $.post("{{url('/addtofavorite')}}", {
        nombre : nombre,
        enlace : enlace,
        precio : precio,
        imagen : imagen,
        tienda : tienda,
        url : url,
        id : id,
        _token : _token
        }, function(data) {
          datos=data.split(',');
          if (datos[0]!="") {
            $('.'+datos[0]+"0").hide();
            $('.'+datos[0]+"1").show();
          }
          if (datos[1]!=""){
            script="<script>$(document).ready(function(){$( '.'+datos[0]+'1' ).click(function() {removefromfavorite(datos[1],datos[0]);});});";
            $('#'+datos[0]).html(script);
          }
        });
}

function removefromfavorite(rowId,id){
    _token = $('#token').val();
    $.post("{{url('/removefromfavorite')}}", {
        rowId : rowId,
        id : id,
        _token : _token
        }, function(data) {
          if (data!="") {
            $('.'+data+"1").hide();
            $('.'+data+"0").show();
          }
        });
}
</script>




@endsection