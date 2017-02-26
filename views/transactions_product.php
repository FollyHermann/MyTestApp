<?php
/**
 * Created by PhpStorm.
 * User: Hermann
 * Date: 21/02/2017
 * Time: 17:39
 */
?>

<?php
$product_code = $_GET['code'];
$db = new DB_Crud();
$sql = "SELECT designation from product where code='{$product_code}'";
$product_row = $db->getSelectAll($sql);
$designation = null;
foreach ($product_row as $row)
{
    $designation = $row["designation"];
}
?>
<div class="page-title">
    <div class="title-env">
        <h1 class="title">
            Liste des transactions de l'article : <?php echo $designation; ?>
        </h1>
    </div>

</div>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-bordered table-striped table-custom">
                <thead >
                <tr>
                    <th width="10%"></th>
                    <th width="15%">Date</th>
                    <th width="15%">Transaction</th>
                    <th width="15%">Prix</th>
                    <th width="10%">Qté</th>
                    <th width="30%">Total</th>
                </tr>
                </thead>

                <tbody class="middle-align" >
                <tr>
                    <?php
                        function get_transaction($type)
                        {
                            $t_type = null;
                            switch ($type)
                            {
                                case 1:
                                    $t_type = "ACHAT";
                                    break;
                                case 2:
                                    $t_type = "VENTE";
                                    break;

                                case 3:
                                    $t_type = "DON";
                                    break;
                            }
                            return $t_type;
                        }
                        $db = new DB_Crud();

                        $sql = "select product.code, 
product_transaction.* 
                        from product_transaction, product
                        where product.code = product_transaction.product_code
                        and product.code = '{$product_code}'
                        order by product_transaction.id DESC";

                    $list = $db->getSelectAll($sql);
                    $counter = 1;
                    $total_transaction = 0;
                    foreach($list as $row):
                    $total_transaction += $row['total'];
                    ?>
                    <td><?php echo $counter++;?></td>
                    <td align="center"><?php echo $row['date_transaction'];?></td>
                    <td align="center"><?php echo get_transaction($row['type_transaction_id']);?></td>
                    <td><?php echo $row['sell_price'];?></td>
                    <td><?php echo $row['quantity'];?></td>
                    <td align="center"><?php echo $row['total'];?></td>
                </tr>
                <?php endforeach;?>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="2" align="right">TOTAL TRANSACTION</td>
                <td align="center" style="background-color: #00aa00; color: #ffffff"><strong>
                        <?php echo $total_transaction ." FCFA";?>
                    </strong>
                </td>
                </tbody>
            </table>
        </div>
    </div>
</div>
