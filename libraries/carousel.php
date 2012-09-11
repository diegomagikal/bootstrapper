<?php
namespace Bootstrapper;

use \HTML;

/**
 * Carousel for creating Twitter Bootstrap style Carousels.
 *
 * @package     Bundles
 * @subpackage  Twitter
 * @author      Patrick Talmadge - Follow @patricktalmadge
 *
 * @see http://twitter.github.com/bootstrap/
 */
class Carousel
{
  /**
   * @var string the previous button content.
   */
  public static $prev = '&lsaquo;';

  /**
   * @var string the next button content.
   */
  public static $next = '&rsaquo;';

  /**
   * Create a Bootstrap carousel. Returns the HTML for the carousel.
   *
   * @param  array    $items      An array of carousel items
   * @param  array    $attributes Attributes to apply the carousel itself
   * @return Carousel
   */
  public static function create($items, $attributes = array())
  {
    $attributes = Helpers::add_class($attributes, 'carousel slide');

    // Calculate the Carousel ID
    $carousel_id = '#'.array_get($attributes, 'id', 'carousel_'.Helpers::rand_string(5));

    // Render main wrapper
    $html = '<div'.HTML::attributes($attributes).'>';

      // Render items
      $html .= '<div class="carousel-inner">';
        foreach ($items as $key => $item) {
          $html .= static::createItem($item, $key == 0);
        }
      $html .= '</div>';

      // Render navigation
      $html .= HTML::link($carousel_id, Carousel::$prev, array('class' => 'carousel-control left', 'data-slide' => 'prev'));
      $html .= HTML::link($carousel_id, Carousel::$next, array('class' => 'carousel-control right', 'data-slide' => 'next'));
    $html .= '</div>';

    return $html;
  }

  /**
   * Create a carousel item. Returns a HTML element for one slide.
   *
   * @param  array  $item      A carousel item to render
   * @param  bool   $is_active Whether the item is active or not
   * @return string
   */
  protected static function createItem($item, $is_active)
  {
    // Gather necessary variables
    $active     = $is_active ? ' active' : '';
    $altText    = array_get($item, 'alt_text', '');
    $attributes = array_get($item, 'attributes', array());
    $caption    = array_get($item, 'caption', '');
    $label      = array_get($item, 'label', '');
    $image      = array_get($item, 'image');

    // If we were given an array of image paths instead of arrays
    if(!$image and is_string($item)) $image = $item;

    // Build HTML
    $html = '<div class="item'.$active.'">';

      // Render the image
      $html .= HTML::image($item, $altText, $attributes);

      // If we have a caption, render it
      if($caption or $label) {
        $html .= '<div class="carousel-caption">';
          if($label) $html .= '<h4>'.$label.'</h4>';
          if($caption) $html .= '<p>'.$caption.'</p>';
        $html .= '</div>';
      }

    $html .= '</div>';

    return $html;
  }
}