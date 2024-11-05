<?php
// This is just for very basic implementation reference, in production, you should validate the incoming requests and implement your backend more securely.
// Please refer to this docs for snap popup:
// https://docs.midtrans.com/en/snap/integration-guide?id=integration-steps-overview

namespace Midtrans;

require_once dirname(__FILE__) . '/../../Midtrans.php';
// Set Your server key
// can find in Merchant Portal -> Settings -> Access keys
Config::$serverKey = 'SB-Mid-server-s9KSgdTdmwApNsMjS7nNL5HB';
Config::$clientKey = 'SB-Mid-client-dCdGmTe0qCwjaCDH';

// non-relevant function only used for demo/example purpose
printExampleWarningMessage();

// Uncomment for production environment
// Config::$isProduction = true;
Config::$isSanitized = Config::$is3ds = true;

$order_id = $_GET['order_id'];

include ('../../../koneksi.php');
$query = "SELECT * FROM reservasi WHERE order_id = '".$order_id."'";
$sql = mysqli_query($con, $query);
$data = mysqli_fetch_assoc($sql);


// Required
$transaction_details = array(
    'order_id' => $order_id,
    'gross_amount' => 30000, // no decimal allowed for creditcard
);

// Optional
$item_details = array (
    array(
        'id' => 'a1',
        'price' => 30000,
        'quantity' => 1,
        'name' => "Reservasi"
    ),
  );
// Optional
$customer_details = array(
    'first_name'    => $data['nama_lengkap'],
    'last_name'     => "",
    'email'         => $data['email'],
    'phone'         => $data['nomor_telepon'],
);
// Fill transaction details
$transaction = array(
    'transaction_details' => $transaction_details,
    'customer_details' => $customer_details,
    'item_details' => $item_details,
);

$snap_token = '';
try {
    $snap_token = Snap::getSnapToken($transaction);
}
catch (\Exception $e) {
    echo $e->getMessage();
}


function printExampleWarningMessage() {
    if (strpos(Config::$serverKey, 'your ') != false ) {
        echo "<code>";
        echo "<h4>Please set your server key from sandbox</h4>";
        echo "In file: " . __FILE__;
        echo "<br>";
        echo "<br>";
        echo htmlspecialchars('Config::$serverKey = \'SB-Mid-server-s9KSgdTdmwApNsMjS7nNL5HB\';');
        die();
    } 
}

?>

<!DOCTYPE html>
<html>
    <body>
        <button id="pay-button">Pilih Metode Pembayaran</button>
        <pre><div id="result-json">JSON result will appear here after payment:<br></div></pre> 

        <!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo Config::$clientKey;?>"></script>
        <script type="text/javascript">
            document.getElementById('pay-button').onclick = function(){
                // SnapToken acquired from previous step
                snap.pay('<?php echo $snap_token?>', {
                    // Optional
                    onSuccess: function(result){
                        /* You may add your own js here, this is just example */
                        document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                        window.location.href = '../../../finish/index.html'; // redirect to finish/konfirmasi.html
                    },
                    // Optional
                    onPending: function(result){
                        /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    },
                    // Optional
                    onError: function(result){
                        /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    }
                });
            };
        </script>
    </body>
</html>

