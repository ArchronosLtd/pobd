<?php
  function my_newsletter_register_blocks() {
    $dir = __DIR__ . '/weekly-news-block';
    TNP_Composer::register_block($dir);
  }
  add_action('newsletter_register_blocks', 'my_newsletter_register_blocks');