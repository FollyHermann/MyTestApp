<?php
/**
 * Created by PhpStorm.
 * User: Hermann
 * Date: 21/02/2017
 * Time: 17:39
 */
?>
<div class="page-title">
    <div class="title-env">
        <h1 class="title">
            Liste des transactions
        </h1>
    </div>
    <div class="breadcrumb-env">
        <form role="form" class="form-inline" onsubmit="return false">

            <div class="form-group">
                <div class="input-group">
                    <input type="text" placeholder="Date de début"
                           class="form-control datepicker"
                           name="startDate" id="startDate"
                           readonly>
                    <div class="input-group-addon">
                        <a href="#"><i class="linecons-calendar"></i></a>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <input type="text" id="endDate" name="endDate"
                           placeholder="Date de fin"
                           class="form-control datepicker" readonly>
                    <div class="input-group-addon">
                        <a href="#"><i class="linecons-calendar"></i></a>
                    </div>
                </div>
            </div>

            <div class="form-group inline pull-right">
                <button class="btn btn-primary" onclick="get_transaction_list()">Afficher</button>
                <button class="btn btn-info" onclick="create_transaction()">Nouveau</button>

            </div>

        </form>
    </div>
</div>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-bordered table-striped table-custom">
                <thead >
                <tr>
                    <th width="5%"></th>
                    <th width="10%">Date</th>
                    <th width="15%">Code</th>
                    <th width="10%">Transaction</th>
                    <th width="25%">Produit</th>
                    <th width="10%">Prix</th>
                    <th width="10%">Qté</th>
                    <th width="15%">Total</th>
                </tr>
                </thead>

                <tbody class="middle-align" id="transactions">

                </tbody>
            </table>
        </div>
    </div>
</div>
