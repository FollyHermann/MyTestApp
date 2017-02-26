<?php
/**
 * Created by PhpStorm.
 * User: Hermann
 * Date: 22/02/2017
 * Time: 23:46
 */
?>
<div class="modal fade" id="modal-add-transaction" data-backdrop="static">
    <div class="modal-dialog" style="width: 80%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Fiche transaction</h4>
            </div>
            <form id="transaction_form" method="post">
                <div class="modal-body">

                    <div id="animation_image" style="line-height: 35px">
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label">Article</label>

                                <script type="text/javascript">
                                    jQuery(document).ready(function($)
                                    {
                                        $("#product_id").select2({
                                            placeholder: 'Selectionnez un produit...',
                                            allowClear: true
                                        }).on('select2-open', function()
                                        {
                                            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                                        });
                                        $('#product_id').change(function () {
                                            var sell_price = $('#product_id').find(":selected").data('decimal');
                                            var left_stock = $('#product_id').find(":selected").data('value');
                                            var id = $('#product_id').find(":selected").data('id');
                                            $('#sell_price').val(sell_price);
                                            $('#left_stock').val(left_stock);
                                            $('#id').val(id);
                                        });


                                    });
                                </script>
                                    <select id="product_id" class="form-control"
                                            name="product_id">
                                        <option></option>
                                        <?php
                                        $db = new DB_Crud();
                                        $sql = "SELECT * FROM product";
                                        $stmt = $db->getSelectAll($sql);
                                        foreach($stmt as $row)
                                        {
                                            ?>
                                            <option
                                                data-decimal="<?php echo $row['sell_price']; ?>"
                                                value="<?php echo $row['id']; ?>"
                                                data-id="<?php echo $row['id']; ?>"
                                                data-value="<?php echo $row['quantity']; ?>"
                                                data-text="<?php echo $row['code']; ?>">
                                                <?php echo $row['designation']; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Type de transaction</label>

                                <script type="text/javascript">
                                    jQuery(document).ready(function($)
                                    {
                                        $("#transaction_id").select2({
                                            placeholder: 'Selectionnez un type',
                                            allowClear: true
                                        }).on('select2-open', function()
                                        {
                                            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                                        });

                                    });
                                </script>
                                <select id="transaction_id" class="form-control"
                                        name="transaction_id">
                                    <option></option>
                                    <?php
                                    $db = new DB_Crud();
                                    $sql = "SELECT * FROM product_transaction_type";
                                    $stmt = $db->getSelectAll($sql);
                                    foreach($stmt as $row)
                                    {
                                        ?>
                                        <option
                                            value="<?php echo $row['id']; ?>"
                                            data-id="<?php echo $row['id']; ?>">
                                            <?php echo $row['type']; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Prix de vente</label>
                                <input type="text" class="form-control" name="sell_price" id="sell_price"
                                       onkeypress="return IsNumeric(event);" ondrop="return false;"
                                       onpaste="return false;" disabled>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                    <input type="hidden" class="form-control"
                                           name="id" id="id"
                                           onkeypress="return IsNumeric(event);"
                                           ondrop="return false;"
                                           onpaste="return false;" disabled>
                                <input type="hidden" class="form-control"
                                       name="transaction_code" id="transaction_code"
                                       onkeypress="return IsNumeric(event);"
                                       ondrop="return false;"
                                       onpaste="return false;" disabled>
                                <label class="control-label">Quantité en stock</label>
                                <input type="text" class="form-control"
                                       name="left_stock"
                                       id="left_stock"
                                       onkeypress="return IsNumeric(event);"
                                       ondrop="return false;"
                                       onpaste="return false;" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Quantité</label>
                                <input type="text" data-mask="decimal"
                                       class="form-control" name="quantity"
                                       id="quantity" onkeypress="return IsNumeric(event);"
                                       ondrop="return false;" onpaste="return false;">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Notes</label>
                                <input type="text" class="form-control" name="notes" id="notes">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class="col-md-3" align="right">
                            <div class="form-group">
                                <label class="control-label" style="color: #ffffff">######</label>
                                <button id="add-to-cart"
                                        onclick="add_to_cart()" type="button"
                                        class="btn btn-success">
                                    Mettre sur la liste
                                </button>
                            </div>
                        </div>
                    </div>


                    <div class="row" >
                        <div class="col-md-12" id="body-cart">
                            <table class="table table-bordered table-striped" id="table-cart">
                                <thead >
                                    <tr>
                                        <th style="display:none;"></th>
                                        <th width="10%">code</th>
                                        <th width="35%">Désignation</th>
                                        <th width="15%">Prix</th>
                                        <th width="10%"> Quantité</th>
                                        <th width="25%">Sous-total</th>
                                        <th style="display:none;"></th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody class="middle-align" >

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9"></div>
                        <div class="col-md-3" align="right">
                            <button
                                class="btn btn-danger delete"
                                id="delete_row"
                                onclick="delete_row()"
                                type="button"> Supprimer de la liste
                            </button>
                        </div>
                    </div>
                    <div style="height: 20px"></div>

                    <div class='row'>
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3"></div>
                        <div class="col-md-3" align="right">
                            <div class="form-group">
                                <label>Montant Total</label>
                                <div class="input-group">
                                    <input type="text" class="form-control amountDue"
                                           name="totalTransaction" id="totalTransaction"
                                           onkeypress="return IsNumeric(event);"
                                           ondrop="return false;" onpaste="return false;" disabled>
                                    <div class="input-group-addon">FCFA</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="height: 30px" id="show_loading">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-info" onclick="send_transaction_to_server()">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

