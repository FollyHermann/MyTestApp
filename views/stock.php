<?php
/**
 * Created by PhpStorm.
 * User: Hermann
 * Date: 21/02/2017
 * Time: 12:47
 */
?>
<div class="page-title">
    <div class="title-env">
        <h1 class="title">
            Liste des articles
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


            <div class="form-group pull-right">
                <button class="btn btn-primary btn-single" onclick="display_stock_inventory()">Afficher</button>
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
                    <th width="25%">Designation</th>
                    <th width="10%">Entrées</th>
                    <th width="10%">Sorties</th>
                    <th width="10%">Stock</th>
                    <th width="15%">Dépenses</th>
                    <th width="15%">Recettes</th>
                    <th width="10%">Balance</th>
                </tr>
                </thead>
                <tbody class="middle-align" id="inventory">
                
                </tbody>
            </table>
        </div>
    </div>
</div>

