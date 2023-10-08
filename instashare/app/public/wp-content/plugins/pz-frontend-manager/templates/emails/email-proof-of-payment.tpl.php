<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body style="width:100%; margin: 0; padding: 0;">
    <div>
      <div>
        <div style="line-height:20px;font-size:1px; width:100%">&nbsp;</div>
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
          <h3 style="font-size: 20px;"><?php echo esc_html__( 'Customer Proof of Payment', 'pz-frontend-manager' );?></h3>
          <p><?php echo esc_html__( 'Just click below to download', 'pz-frontend-manager' );?></p>
          <div style="padding-top:20px; padding-bottom:20px;">
           <a class="center fixedwidth btn-activate" align="center" border="0" href="<?php echo wp_get_attachment_url( $attachment_id );?>" title="<?php esc_html_e('Download now!','pz-frontend-manager'); ?>" style="font-family:Arial; line-height:56px; outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: none;height: auto;float: none;width: 100%;max-width: 385px; height: 56px; background:<?php echo esc_html($color); ?>; border-radius: 50px; color:white; font-size: 14px; text-decoration: none; letter-spacing: 3px; cursor: pointer;  margin: auto" width="320" download><?php esc_html_e('Download','pz-frontend-manager'); ?></a>           
          </div>
          <div>
        </div>
        <div style="color:#67626E; 
                font-family: Apercu;
                font-style: normal;
                font-weight: normal;
                font-size: 12px;
                line-height: 140%;
                text-align:center;
                width: 380px;
                margin:auto">
          <p><?php echo esc_html__( 'You receive these emails because you are admin in ', 'pz-frontend-manager' );?><strong><?php apply_filters('pzfm_company_name_information_email' , bloginfo('name') );?></strong><br/><?php echo pzfm_default_address(); ?></p>
        </div>
      </div>
  </body>
  </html>