<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body style="width:100% margin: 0; padding: 0;">
    <div>
      <div>
        <div style="line-height:20px;font-size:1px; width:100%">&nbsp;</div>
        <img class="center fixedwidth" align="center" border="0" src="<?php echo esc_url( $logo ); ?>" alt="Logo" title="<?php echo bloginfo('name'); ?>" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;max-width: 200px; margin: auto; width: 50%;" width="200">
        <div style=" 
          padding:50px;
          outline: none;
          text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;
          display: block !important;
          border: 1px solid #EBE8E4;
          border-radius: 20px; 
          height: auto;float: none;
          width: 100%;
          max-width: 480px; 
          min-height: 400px;  
          margin: auto; 
          width: 50%; 
          padding: 40px; 
          text-align: center; 
          font-family:Arial; 
          color: #4B5161;" width="480">
            <h3 style="font-size: 20px;"><?php echo esc_html__( 'You’re password has been reset', 'pz-frontend-manager' );?></h3>
            <div style="padding-top:20px; padding-bottom:20px;">
            <p style="margin:3!important;"><?php echo esc_html__( 'Email', 'pz-frontend-manager' );?></p>
            <h3 style="text-decoration: none; margin-bottom: 0;"><a name="useremail"><?php echo esc_html( $from_email ); ?></a></h3>
            <p style="margin:3!important;"><?php echo esc_html__( 'Password', 'pz-frontend-manager' );?></p>
            <h3 style="text-decoration:none; margin-bottom: 25px;"><a name="password"><?php echo esc_html( $password ); ?></a></h3>
        </div>
          <div style="padding-top:10px; padding-bottom:40px;">
            <p><?php echo esc_html__( 'Regards,', 'pz-frontend-manager' );?></p>
            <h3><?php echo apply_filters('pzfm_company_name_information_email' , bloginfo('name') );?></h3>
          </div>
      </div>
      <div style="color:#67626E; 
              font-family: Apercu;
              font-style: normal;
              font-weight: normal;
              font-size: 12px;
              line-height: 140%;
              text-align:center;
              width: 360px;
              margin:auto">
        <p><?php echo esc_html__( 'You receive these emails because you signed up to ', 'pz-frontend-manager' );?><strong><?php apply_filters('pzfm_company_name_information_email' , bloginfo('name') );?></strong><br/><?php echo pzfm_default_address(); ?></p>
      </div>
    </div>
  </body>
</html>