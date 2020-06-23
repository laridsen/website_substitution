<!-- view boutique -->
<!-- Header -->
@extends ('layouts.layout')
<!--
    This page shows us the items to sell
    -->
<!--Start Content -->

@section('contenu')


    <h4 class="categorie p-5 text-muted" align="center">Produits :</h4>
    <div class="container">
        <div class="row justify-content">

			<?php for($i=0;$i<$number;$i++){ ?>
            <!-- Information -->
                <div class="col-md-7 col-9 mb-6">
                    <div class="card">
                        <img class="card-img-top border-bottom-1" src=" <?php echo($product[$i]->picture); ?>" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo($product[$i]->Name) ?> </h5>
                            <p class="card-text"><?php echo($product[$i]->Description) ?> </p>
                        </div>
                        <!-- add button -->

                            <form class="card-footer"  method="POST">
								{{csrf_field()}}
                                <small class="text-muted">
									<input type="hidden" name="ID" value=" <?php echo($product[$i]->ID) ?> ">
									<input type="number" name="Quantity" value="0" min="0" max="100">
                                    <button type="submit" class="btn btn-outline-primary form-control">commander<i class="ml-1 fas fa-cart-arrow-down"></i></button>
                                </small>
                            </form>

                    </div>
                </div><?php
			} ?>
        </div>
    </div>
    <br>

@endsection

<!-- End Content -->
