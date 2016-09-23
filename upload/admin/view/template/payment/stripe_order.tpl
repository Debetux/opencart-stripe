<h2>Stripe Charge</h2>
<div class="alert alert-success" id="sagepay_direct_transaction_msg" style="display:none;"></div>
<table class="table table-striped table-bordered">
  <tr>
    <td><?php echo 'Link'; ?></td>
    <td><a class="btn btn-info btn-xs" href="https://dashboard.stripe.com/<?php echo $stripe_environment; ?>/payments/<?php echo $charge['id']; ?>">Stripe charge</a></td>
  </tr>

  <tr>
    <td><?php echo 'Fee'; ?></td>
    <td><?php echo $transaction['fee'] / 100; ?> <?php echo $transaction['currency']; ?></td>
  </tr>
  <tr>
      <td>Net</td>
      <td><?php echo $transaction['net'] / 100; ?> <?php echo $transaction['currency']; ?></td>
  </tr>
  <tr>
    <td><?php echo 'Refunded'; ?></td>
    <td>
        <?php if($charge['amount_refunded'] == $charge['amount']): ?>
            <span class="label label-warning">Yes</span>
        <?php elseif($charge['amount_refunded'] > 0): ?>
            <span class="label label-success">Partial</span>
        <?php else: ?>
            <span class="label label-info">No</span>
        <?php endif; ?>
    </td>
  </tr>
  <tr>
    <td><?php echo 'Refund'; ?></td>
    <td>
        <div class="row">
            <div class="col-sm-3">
                <div class="input-group">
                  <input type="text" class="form-control" id="input-refund-amount" value="<?php echo ($charge['amount'] - $charge['amount_refunded']) / 100; ?>">
                  <span class="input-group-addon"><?php echo strtoupper($charge['currency']); ?></span>
                </div>
            </div>
            <div class="col-sm-2">
                <a class="btn btn-primary" id="button-refund" style="display:block">
                    <i class="fa fa-circle-o-notch fa-spin fa-lg" id="img-loading-refund" style="display:none;"></i>
                    <?php echo $button_refund; ?>    
                </a>         
            </div>
        </div>
    </td>
  </tr>
  <tr>
      <td>Refunds</td>
      <td>
          <table class="table table-striped table-bordered" id="stripe_refunds_table">
                  <thead>
                    <tr>
                      <td class="text-left"><strong>Amount</strong></td>
                      <td class="text-left"><strong>Date</strong></td>
                      <td class="text-left"><strong>User</strong></td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($charge['refunds']['data'] as $refund) { ?>
                    <tr>
                      <td class="text-left"><?php echo $refund['amount'] / 100; ?> <?php echo $refund['currency']; ?></td>
                      <td class="text-left"><?php echo date($datetime_format, $refund['created']); ?></td>
                      <td class="text-left">
                          <?php if(isset($refund['metadata']['opencart_user_username'])): ?>
                            <?php echo $refund['metadata']['opencart_user_username']; ?>
                          <?php endif; ?>
                      </td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
      </td>
  </tr>
</table>

<script type="text/javascript">
  $("#button-refund").click(function() {
        if (confirm('<?php echo $text_confirm_refund; ?>')) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                data: {'order_id': <?php echo $order_id; ?>, 'amount': $('#input-refund-amount').val() },
                url: 'index.php?route=extension/payment/stripe/refund&token=<?php echo $token; ?>',
                beforeSend: function() {
                    $('#button-refund').prop('disabled', true);
                    $('#img-loading-refund').show();
                },
                success: function(data) {
                    if (data.error == false) {
                      var $table = $('#stripe_refunds_table').find('tbody');
                      $table.prepend('<tr><td class="text-left">'+$('#input-refund-amount').val()+'</td><td>now</td><td>you</td></tr>');
                    }
                    if (data.error == true) {
                        alert(data.msg);
                    }

                    $('#button-refund').prop('disabled', false);
                    $('#img-loading-refund').hide();
                }
            });
        }
    });
</script>
