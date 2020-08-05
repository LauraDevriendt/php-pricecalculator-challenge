<?php require 'includes/header.php' ?>
    <!-- this is the view, try to put only simple² if's and loops here.
    Anything complex should be calculated in the model -->
    <section class="container">
        <h1 class="my-3">Price calculator</h1>
        <div class="my-3">
            <h4>FORM</h4>
            <form method="post">
                <div class="form-group">
                    <label for="products"> Choose Product: </label>
                    <select name="products" id="products">
                        <?php
                        $products = $pdo->getProducts();
                        /**
                         * @var Product[] $products
                         */
                        foreach ($products as $productSelect) {
                            $priceTest = $productSelect->getPrice() / 100;
                            echo "<option value='{$productSelect->getId()}'>{$productSelect->getName()}: {$priceTest} euro</option>";
                        } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="customers">Choose Customer:</label>
                    <select name="customers" id="customers">
                        <?php
                        $customers = $pdo->getCustomers();
                        /**
                         * @var Customer[] $customers
                         */
                        foreach ($customers as $customerTest) {
                            echo "<option value='{$customerTest->getId()}'>{$customerTest->getFirstName()}-{$customerTest->getLastName()}</option>";
                        } ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" name='submitPriceSearch' class="btn btn-primary mb-2">Submit</button>
                </div>
            </form>
            <h5 class="my-5">Best price
                is <?php if (!empty($_POST['products']) && !empty($_POST['customers'])) echo "$bestPrice euro"; ?></h5>
        </div>
    </section>

<?php if (!empty($_POST['products']) && !empty($_POST['customers']))  :?>

    <section id="detailedTables" class="my-5 container">
        <div id="customerTableSection">
            <h2>Details of calculation</h2>
            <table class="table">
                <thead class="thead-light">
                <tr>
                    <th><?php
                        $price=$product->getPrice()/100;
                        echo "{$product->getName()}: {$price} euro"?></th>
                    <th>Variabel Discount</th>
                    <th>Price minus Variable Discount</th>
                    <th>Fixed Discount</th>
                    <th>Price minus Fixed Discount</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>Customer:</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <?php
                    /** @var Customer $customer */
                    ?>
                    <td><?php echo "{$customer->getFirstName()} - {$customer->getLastName()}"?></td>
                    <td scope="row"><?php echo ($customer->getDiscount()->getType()!==Discount::PERCENTAGE_TYPE)? "{$customer->getDiscount()->getValue()} %":0;  ?></td>
                    <td>
                        <?php
                        $priceVarCustomer=$customer->getDiscount()->apply($product->getPrice());
                        echo "$price * (1 - {$customer->getDiscount()->getValue() }%) = $priceVarCustomer euro"
                        ?>
                    </td>
                    <td><?php echo ($customer->getDiscount()->getType()!==Discount::FIXED_TYPE)? "{$customer->getDiscount()->getValue()} euro":0;  ?></td>
                    <td>
                        <?php
                        $priceFixedCustomer=$customer->getDiscount()->apply($product->getPrice());
                        echo "$price - {$customer->getDiscount()->getValue()} = $priceFixedCustomer euro" ?></td>


                </tr>
                <tr>
                    <th>CustomerGroup:</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><?php
                        foreach ($customerGroup->getFamily() as $group) {
                            echo "{$group->getName()}<br>";
                        }
                        ?></td>
                    <td scope="row">
                        <?php
                        foreach ($customerGroup->getFamily() as $group) {
                            echo ($group->getDiscount()->getType()!==Discount::PERCENTAGE_TYPE)? "{$group->getDiscount()->getValue()} %<br>":"0<br>";
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        foreach ($customerGroup->getFamily() as $group) {
                            $priceVarGroup = $group->getDiscount()->apply($product->getPrice());
                            echo "$price * (1 - {$group->getDiscount()->getValue()}%) = $priceVarGroup euro<br>";
                        }
                        ?>
                    </td>
                    <td>
                        <?php foreach ($customerGroup->getFamily() as $group) {
                            echo ($group->getDiscount()->getType()!==Discount::FIXED_TYPE)? "{$group->getDiscount()->getValue()} euro<br>":"0<br>";
                        } ?>
                    </td>
                    <td>
                        <?php
                        foreach ($customerGroup->getFamily() as $group) {
                            $priceFixedGroup = $group->getDiscount()->apply($product->getPrice());
                            echo "$price - {$group->getDiscount()->getValue()} = $priceFixedGroup euro <br>";
                        }
                        ?>
                    </td>

                </tr>
                <tr>
                    <th>Combination:</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><?php  echo"$displayCalculation";?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                </tbody>
            </table>
        </div>

    </section>
<?php  endif ?>



<?php require 'includes/footer.php' ?>