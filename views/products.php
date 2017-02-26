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
        <a href="javascript:;" onclick="create_product();"
           class="btn btn-primary btn-single">Ajouter </a>
    </div>
</div>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-bordered table-striped table-custom">
                <thead >
                <tr>
                    <th width="5%"></th>
                    <th width="10%">Code</th>
                    <th width="25%">Designation</th>
                    <th width="15%">Prix achat</th>
                    <th width="15%">Prix vente</th>
                    <th width="10%">Stock</th>
                    <th width="10%">Image</th>
                    <th width="10%">Options</th>
                </tr>
                </thead>

                <tbody class="middle-align" >
                <tr>
                    <?php
                    $db = new DB_Crud();
                    $list = $db->getSelectAll("SELECT * FROM product order by id desc");
                    $counter = 1;
                    foreach($list as $row):
                    ?>
                    <td><?php echo $counter++;?></td>
                    <td><?php echo $row['code'];?></td>
                    <td><?php echo $row['designation'];?></td>
                    <td><?php echo $row['buy_price'];?></td>
                    <td><?php echo $row['sell_price'];?></td>
                    <td><?php echo $row['quantity'];?></td>
                    <td align="center">
                        <img src="<?php echo "app/images/products/".$row["image"];?>"
                             width="80px" height="50px">
                    </td>
                    <td align="center">
                        <div class="btn-group">
                            <button class="btn btn-icon btn-primary dropdown-toggle" data-toggle="dropdown">
                                <i class="fa-bars"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li>
                                    <a href="javascript:;" onclick="update_product('<?php echo $row['id'];?>');">
                                        Modifier
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="javascript:;" onclick="delete_info('<?php echo $row['id'];?>');">
                                        Supprimer
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="?page=transactions_product&code=<?php echo $row['code'];?>">
                                        Voir les transactions
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>