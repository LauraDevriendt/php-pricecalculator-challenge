<?php require 'includes/header.php'?>
<!-- this is the view, try to put only simple if's and loops here.
Anything complex should be calculated in the model -->
<section>

    <div class="my-3 container">
        <h4>FORM</h4>
        <form method="post">
            <div class="form-group">
                <label for="products"> Choose Product: </label>
                <select name="products" id="products">
                    <?php
                    $products=$pdo->getProducts();
                    /**
                     * @var Product[] $products
                     */
                    foreach ($products as $product){
                        $price= $product->getPrice()/100;
                        echo "<option value='{$product->getId()}'>{$product->getName()}: {$price} euro</option>";
                    } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="customers">Choose Customer:</label>
                <select name="customers" id="customers">
                    <?php
                    $customers=$pdo->getCustomers();
                    /**
                     * @var Customer[] $customers
                     */
                    foreach ($customers as $customer){
                        echo "<option value='{$customer->getId()}'>{$customer->getFirstName()}-{$customer->getLastName()}</option>";
                    } ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" name='submit' class="btn btn-primary mb-2">Submit</button>
            </div>
        </form>
        <h5>Best price is <?php  if (!empty($_POST['products']) && !empty($_POST['customers'])) echo "$price"; //@todo doesn't show price as it should be?></h5>
    </div>
</section>
<?php require 'includes/footer.php'?>