<?php include('Crypto.php') ?>
<?php

error_reporting(0);

$workingKey = '34888D62335F2DA0C626BAA17EB04335';        //Working Key should be provided here.
$encResponse = $_POST["encResp"];            //This is the response sent by the CCAvenue Server
$rcvdString = decrypt($encResponse, $workingKey);        //Crypto Decryption used as per the specified working key.
$order_status = "";
$decryptValues = explode('&', $rcvdString);

$dataSize = sizeof($decryptValues);
echo "<center>";

for ($i = 0; $i < $dataSize; $i++) {
    $information = explode('=', $decryptValues[$i]);
    if ($i == 3) $order_status = $information[1];
}

echo "Redirecting......Please be patient";

if ($order_status === "Success") {
    /*$this->load->model("FeeModel");
    $this->FeeModel->confirm_payment($_SESSION['receipt_id']);*/
    echo "<script>alert('Payment made successfully... Press OK....');
		window.location='http://www.sbssrinagar.com/FrontendController/confirm_payment';</script>";
} else if ($order_status === "Aborted") {
    echo "<script>alert('The transaction was aborted');
		window.location='http://www.sbssrinagar.com'</script>";

} else if ($order_status === "Failure") {
    echo "<script>alert('Failure...');
		window.location='http://www.sbssrinagar.com'</script>";
} else {
    echo "<script>alert('Illegal Access');
		window.location='http://www.sbssrinagar.com'</script>";

}


?>
