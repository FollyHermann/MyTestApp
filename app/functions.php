<?php
/**
 * Created by PhpStorm.
 * User: Hermann
 * Date: 21/02/2017
 * Time: 14:47
 */

include_once ("../database/DB_Crud.php");

if(isset($_POST['operation']))
{
    $method_name = $_POST['operation'];
    $obj = new ExecuteFunction();
    $obj->{$method_name}();
}

class ExecuteFunction
{

    public function product_exist()
    {
        $product = $_POST['designation'];
        $db = new DB_Crud();
        $sql = "SELECT designation from product where designation='{$product}'";
        $product_row = $db->getSelectAll($sql);
        $designation = null;
        foreach ($product_row as $row)
        {
            $designation = $row["designation"];
        }
        if($product == $designation)
        {
            echo "true";
        } else{
            echo "false";
        }
    }

    public function create_product()
    {
        $db = new DB_Crud();
        $code = 'ART-'.$db->formatCode('product', 'id',4);

        $data['designation']     = $_POST['designation'];
        $data['buy_price']  = $_POST['buyprice'];
        $data['sell_price']    = $_POST['sellprice'];
        $data['quantity']    = $_POST['quantity'];
        $data['image']    = $code.'.jpg';

        $data['code'] = $code;

        $db->insert('product', $data);
        $target_image = "images/products/". $code.'.jpg';
        $action = move_uploaded_file($_FILES["image"]["tmp_name"], $target_image);

        if($action)
        {
            header('Location: ../?page=products');
        }

    }

    public function update_product()
    {
        $id = $_POST['id'];
        $db = new DB_Crud();

        $data['designation']     = $_POST['designation'];
        $data['buy_price']  = $_POST['buyprice'];
        $data['sell_price']    = $_POST['sellprice'];

        $db->where('id', $id);
        $db->update('product', $data);

        header('Location: ../?page=products');

    }

    public function get_details_product()
    {
        $db = new DB_Crud();
        $id = $_POST['id'];
        $db->where('id', $id);
        $rs = $db->getRowOf('product');
        echo json_encode($rs);
    }

    public function delete_product()
    {
        $db = new DB_Crud();
        $id = $_POST['id'];
        $db->where('id', $id);
        $db->delete('product');
    }

    public function create_transaction()
    {
        $db = new DB_Crud();
        $code = "TRS-".$db->formatCode('product_transaction','id',6);

        $rows = $_POST['pTableData'];

        $tableData = stripcslashes($rows);
        $tableData = json_decode($tableData,TRUE);

        foreach ($tableData as $row)
        {
            $data['code'] = $code;
            $product_code = $row['code'];
            $data['product_code'] = $product_code;
            $data['date_transaction'] = date('y-m-d');
            $type_transaction_id = $row['transaction_id'];
            $data['type_transaction_id'] = $type_transaction_id;
            $data['sell_price'] = $row['sell_price'];
            $quantity = $row['quantity'];
            $data['quantity'] = $quantity;
            $data['notes'] = $row['notes'];

            $operation['date_transaction'] = date('Y-m-d');
            $data['total'] = $row['total'];
            $db->insert('product_transaction',$data);
            $this->update_product_stock($product_code, $type_transaction_id, $quantity);

        }

    }

    public function update_product_stock($code, $transaction, $quantity)
    {
        $db = new DB_Crud();

        $db->where('code', $code);
        $rs = $db->getRowOf('product');
        $old_quantity = $rs["quantity"];

        switch ($transaction)
        {
            case 1://achat
                $data['quantity'] = $old_quantity + $quantity;
                $db->where('code', $code);
                $db->update('product', $data);
                break;

            case 2: //vente
                $data['quantity'] = $old_quantity - $quantity;
                $db->where('code', $code);
                $db->update('product', $data);
                break;

            case 3://don
                $data['quantity'] = $old_quantity - $quantity;
                $db->where('code', $code);
                $db->update('product', $data);
                break;

        }
    }

    public function get_inventory_details()
    {

        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        $db = new DB_Crud();
        $sql = "select * from product order by product.id DESC";

        $list = $db->getSelectAll($sql);
        $counter = 1;
        ?>
    <tr>
        <?php
            $total_incomes = 0;
            $total_expenses = 0;
            foreach($list as $row)
            {
                $income_count = $this->get_income_stock($row['code'], $start_date, $end_date);
                $outgoing_count = $this->get_outgoing_stock($row['code'], $start_date, $end_date);
                $stock_balance = $income_count - $outgoing_count;
                $income_amount = $income_count * $row['buy_price'];
                $total_incomes += $income_amount;
                $outgoing_amount = $outgoing_count * $row['sell_price'];
                $total_expenses += $outgoing_amount;

                $amount_balance = $income_amount - $outgoing_amount;
                ?>
                <td><?php echo $counter++;?></td>
                <td><?php echo $row["designation"];?></td>
                <td><?php echo $income_count;?></td>
                <td><?php echo $outgoing_count ;?></td>
                <td align="center" style=" color:floralwhite ;background-color:<?php echo ($stock_balance < 0)?'#89090a': '#00aa00'?>">
                    <?php echo $stock_balance ;?>
                </td>
                <td><?php echo $income_amount;?></td>
                <td><?php echo $outgoing_amount?></td>

                <td align="center" style=" color:floralwhite ;background-color:<?php echo ($amount_balance < 0)?'#89090a': '#00aa00'?>">
                    <?php echo $amount_balance ;?>
                </td>
    </tr>

            <?php
            }
        $total_balance = $total_incomes - $total_expenses;
        ?>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td align="center" style=" color:floralwhite ;background-color:<?php echo ($total_expenses < 0)?'#89090a': '#00aa00'?>">
            <?php echo $total_expenses.' FCFA' ?>
        </td>
        <td align="center" style=" color:floralwhite ;background-color:<?php echo ($total_incomes < 0)?'#89090a': '#00aa00'?>">
            <?php echo $total_incomes.' FCFA' ?>
        </td>
        <td align="center" style=" color:floralwhite ;background-color:<?php echo ($total_balance < 0)?'#89090a': '#00aa00'?>">
            <?php echo $total_balance.' FCFA' ?>
        </td>


<?php
    }

    public function get_income_stock($code_product, $start_date, $end_date)
    {

        $db = new DB_Crud();
        $sql = "select sum(quantity) as income_count from product_transaction
                where type_transaction_id = 1
                and date_transaction between '{$start_date}' and '{$end_date}'
                and product_code = '{$code_product}'
                group by product_code";
        $list = $db->getSelectAll($sql);
        $income_count = null;
        foreach ($list as $row)
        {
            $income_count = $row['income_count'];
        }
        return $income_count;
    }

    public function get_outgoing_stock($code_product, $start_date, $end_date)
    {

        $db = new DB_Crud();
        $sql = "select sum(quantity) as sum_quantity from product_transaction
                where type_transaction_id BETWEEN '1' AND '2' 
                and date_transaction between '{$start_date}' and '{$end_date}'
                and product_code = '{$code_product}'
                group by product_code";
        $list = $db->getSelectAll($sql);
        $income_count = null;
        foreach ($list as $row)
        {
            $income_count = $row['sum_quantity'];
        }
        return $income_count;
    }
    
    public function get_transaction($type)
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


    public function get_transaction_list()
    { ?>
    <tr>
    <?php
        $db = new DB_Crud();
        $sql = "select product.code, product.designation, 
        product_transaction.* 
        from product_transaction, product
        where product.code = product_transaction.product_code
        order by product_transaction.id DESC";

        $list = $db->getSelectAll($sql);
        $counter = 1;
        foreach($list as $row)
            {
                ?>
                <td><?php echo $counter++;?></td>
                <td align="center"><?php echo $row['date_transaction'];?></td>
                <td align="center"><?php echo $row['code'];?></td>
                <td align="center"><?php echo $this->get_transaction($row['type_transaction_id']);?></td>
                <td><?php echo $row['designation'];?></td>
                <td><?php echo $row['sell_price'];?></td>
                <td><?php echo $row['quantity'];?></td>
                <td><?php echo $row['total'];?></td>

                </tr>
                <?php
            }
       }

}

