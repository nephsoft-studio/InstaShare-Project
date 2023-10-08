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
          <h3 style="font-size: 20px;"><?php echo esc_html__( 'New User Registered', 'pz-frontend-manager' );?></h3>
          <p><?php echo esc_html__( 'Hi Admin! Someone registered on ', 'pz-frontend-manager' ).bloginfo('name');?></p>
          <div style="padding-top:20px; padding-bottom:20px;">
            <p style="margin:3!important;"><?php echo esc_html__( 'Name', 'pz-frontend-manager' );?></p>
            <h3 style="text-decoration: none; margin-bottom: 0;"><a id="username"><?php echo esc_html($user_firstname) .' '. esc_html($user_lastname); ?></a></h3>
          </div>
          <div style="padding-top:20px; padding-bottom:20px;">
            <p style="margin:3!important;"><?php echo esc_html__( 'Email', 'pz-frontend-manager' );?></p>
            <h3 style="text-decoration: none; margin-bottom: 0;"><a id="useremail"><?php echo esc_html( $user_email ); ?></a></h3>
          </div>
          <div style="padding-top:20px; padding-bottom:20px;">
            <p style="margin:3!important;"><?php echo esc_html__( 'Profile Url', 'pz-frontend-manager' );?></p>
            <h3 style="text-decoration: none; margin-bottom: 0;"><a id="authorurl"><?php echo esc_html( $blog_url ); ?></a></h3>
          </div>
          <div>
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
          <p><?php echo bloginfo('name') .' '. pzfm_default_address(); ?></p>
        </div>
      </div>
  </body>
  </html>