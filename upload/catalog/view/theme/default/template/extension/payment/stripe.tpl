
<div class="row">
  <div class="col-md-4">

    <form class="" id="payment-form">


      <?php if($cards): ?>
      <fieldset>
        <legend>Choose existing credit card</legend>
        <div class="form-group col-sm-12">
          <label class="control-label" for="card-number">Cards</label>
         
          <select class="form-control" id="existing-card-select">
            <option value="0">-----</option>
            <?php foreach($cards->rows as $card): ?>
            <option value="<?php echo $card['stripe_card_id']; ?>">
              <?php echo $card['brand']; ?>
              **** **** **** <?php echo $card['last_four']; ?>
              <?php echo $card['exp_month']; ?> / <?php echo $card['exp_year']; ?>  
            </option>
            <?php endforeach; ?>
          </select>
        </div>
      </fieldset>
      <?php endif; ?>


      <fieldset>
        <legend><?php echo $text_credit_card; ?></legend>
        <div class="form-group required col-sm-12">
          <label class="control-label" for="card-number"><?php echo $entry_cc_number; ?></label>
          <div class="input-group">
              <input type="text" class="form-control" id="card-number" name="card-number" placeholder="Valid Card Number" required="" autofocus="" data-stripe="number">
              <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
          </div>
        </div>

        <div class="form-group required col-sm-6">
          <label for="card-expiry-month"><?php echo $entry_cc_expire_date; ?></label>
          <div class="row">
            <div class="col-xs-6 col-lg-6">
              <input type="text" class="form-control" name="card-expiry-month" id="card-expiry-month" placeholder="MM" required="" data-stripe="exp_month">
            </div>
            <div class="col-xs-6 col-lg-6">
              <input type="text" class="form-control" name="card-expiry-year" id="card-expiry-year" placeholder="YY" required="" data-stripe="exp_year">
            </div>
          </div>
        </div>


        <div class="form-group required col-sm-6">
          <label class="control-label" for="card-cvc"><?php echo $entry_cc_cvv2; ?></label>
          <div class="">
            <input type="text" name="card-cvc" value="" placeholder="<?php echo $entry_cc_cvv2; ?>" id="card-cvc" class="form-control" data-stripe="cvc"/>
          </div>
        </div>

        <?php if($can_store_cards): ?>
        <div class="form-group col-sm-6">
          <div class="checkbox">
              <label>
                <input type="checkbox" id="save-credit-card"> Save credit card
              </label>
            </div>
        </div>
        <?php endif; ?>
      </fieldset>
    </form>

  </div>
</div>


<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary" />
  </div>
</div>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript"><!--

$('#button-confirm').bind('click', function() {

  var $form = $('#payment-form');
  var $button_confirm = $('#button-confirm');
  var $existing_cards_select = $('#existing-card-select');

  $button_confirm.attr('disabled', true);
  $form.before('<div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_wait; ?></div>');

  if($existing_cards_select.find('option:selected').val() != '0' && $existing_cards_select.find('option:selected').val() != undefined) {
    $.ajax({
      url: 'index.php?route=extension/payment/stripe/send',
      type: 'post',
      data: { 
        card: $existing_cards_select.find('option:selected').val(),
        saveCreditCard: false,
        existingCard: true
      },
      dataType: 'json',
      complete: function() {
        $('.alert').remove();
        $button_confirm.prop('disabled', false);
      },
      success: function(json) {
        if (json['error']) {
          alert(json['error']);
        }
      
        if (json['success']) {
          location = json['success'];
        }
      }
    });
    return true;
  } else {
    Stripe.setPublishableKey('<?php echo $publishable_key; ?>');

    function stripeResponseHandler(status, response) {

      // Grab the form:
      var $form = $('#payment-form');

      if (response.error) { // Problem!
        $('.alert').remove();
        $button_confirm.attr('disabled', false);

        // Show the errors on the form
        $form.before('<div class="alert alert-error">'+ response.error.message +'</div>');
        alert('error');
        $button_confirm.prop('disabled', false);

      } else { // Token was created!

        // Get the token ID:
        var token = response.id;
        $.ajax({
          url: 'index.php?route=extension/payment/stripe/send',
          type: 'post',
          data: { 
            card: token,
            saveCreditCard: !!$('#save-credit-card').prop('checked'),
            existingCard: false
          },
          dataType: 'json',
          complete: function() {
            $('.alert').remove();
            $button_confirm.prop('disabled', false);
          },
          error: function(json) {
            alert(json);
          },
          success: function(json) {
            if (json['error']) {
              alert(json['error']);
            }
          
            if (json['success']) {
              location = json['success'];
            }
          }
        });

      }
    }

    Stripe.card.createToken({
      number: $('#card-number').val(),
      cvc: $('#card-cvc').val(),
      exp_month: $('#card-expiry-month').val(),
      exp_year: $('#card-expiry-year').val()
    }, stripeResponseHandler);
  }
	
});
//--></script>
