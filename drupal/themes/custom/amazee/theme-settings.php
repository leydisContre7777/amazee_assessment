<?php
/**
 * @file theme-settings.php
 * Implementation of additional theme settings for amazee ONLINE
 */
use Drupal\Core\Form\FormStateInterface;
use Drupal\breakpoint\BreakpointInterface;

/**
 * Implementation of additional settings for amazee theme
 * @implements hook_form_system_theme_settings_alter
 * @param array $form
 * @param FormStateInterface $form_state
 * @param string $form_id
 */
function amazee_form_system_theme_settings_alter(&$form, FormStateInterface &$form_state,
        $form_id = NULL) {
 
    // Work-around for a core bug affecting admin themes. See issue #943212.
    // https://www.drupal.org/project/drupal/issues/943212
    if (isset($form_id)) {
        return;
    }
   
    $settings_description = 'Since amazee is using Bootstrap\'s 3 Grid component, '
        .'responsive behaviour could be easily configured. '
        .'Please use form beyond to adjust how the general regions should be arranged '
        .'according to diferent screens. '
        .'The layout contain 12 columns, you can set the count of columns that each region should take '
        .'on each screen width.'
        .'Take a look at <a href="https://getbootstrap.com/docs/3.3/css/#grid" target="_blank">'
        . 'Boostrap grid component</a> to learn more.';
    
    $form['amazee_responsive_settings'] = [
        '#type' => 'details',
        '#title' => t('Responsive behavior settings'),
        '#collabsible' => TRUE,
        '#collapsed' => FALSE,
        '#tree' => TRUE,
        '#description' => t($settings_description)
    ];
    
    // The set of rules for responsive behavior of each column
    // Sidebar at the very left
    $regions = ['sidebar_first', 'sidebar_second', 'content'];
    foreach($regions as $region) {
        amazee_region_responsive_settings($region, $form['amazee_responsive_settings']);
    }
    
    // Settings for header components
    amazee_header_components_settings($form, $form_state);
}

/**
 * Responsive behavior settings for the given region
 * @param string $region Name of region 
 * @param array $form Parent container
 */
function amazee_region_responsive_settings($region, &$form) {
    
    $form[$region] = [
        '#type' => 'details',
        '#collapsible' => TRUE,
        '#collapsed' => TRUE,
        '#tree' => TRUE,
        '#title' => $region,
    ];
    
    /**
     * Breakpoint manager service
     * @var \Drupal\breakpoint\BreakpointManagerInterface
     */
    $breakpoint_manager = \Drupal::service('breakpoint.manager');
    foreach ($breakpoint_manager->getBreakpointsByGroup('amazee') as $id => $breakpoint) {
        amazee_region_breakpoint_settings($breakpoint, $id, $region, $form[$region]);
    }
}

/**
 * Breakpoint settings field
 * @param BreakpointInterface $breakpoint
 * @param string $breakpoint_id
 * @param string $region
 * @param array $form
 */
function amazee_region_breakpoint_settings(BreakpointInterface $breakpoint, $breakpoint_id, $region, &$form) {
    list (, $name) = explode('.', $breakpoint_id);
    $form[$name] = [
        '#title' => $breakpoint->getLabel(),
        '#type' => 'select',
        '#options' => array_combine(range(1,12), range(1,12)),
        '#default_value' => theme_get_setting("amazee_responsive_settings.{$region}.{$name}", 'amazee')
    ];
}

/**
 * Settings for components in the header
 * @param array $form
 * @param FormStateInterface $form_state
 */
function amazee_header_components_settings(&$form, FormStateInterface &$form_state) {

    $form['amazee_header'] = [
        '#type' => 'details',
        '#title' => t('Header components settings'),
        '#collabsible' => TRUE,
        '#collapsed' => FALSE,
        '#tree' => TRUE,
        '#description' => t('Configure content of components in header')
    ];
    
    $form['amazee_header']['support'] = [
        '#type' => 'fieldset',
        '#tree' => TRUE,
        '#title' => t('Support'),
        '#description' => t('Usage: {{ amazee_header.support.link_text }}, {{ amazee_header.support.link_href }}'),
        
        'link_text' => [
            '#type' => 'textfield',
            '#title' => t('Link text'),
            '#default_value' => theme_get_setting('amazee_header.support.link_text'),
            '#description' => t('Example: "Contact support".')
        ],
        
        'link_href' => [
            '#type' => 'textfield',
            '#title' => t('Link absolute path'),
            '#default_value' => theme_get_setting('amazee_header.support.link_href'),
            '#description' => t('Provide an absolute internal link. Example: "/support".')
        ]
    ];
    
    $form['amazee_header']['personal_area'] = [
        '#type' => 'fieldset',
        '#tree' => TRUE,
        '#title' => t('Personal area'),
        '#description' => t('Usage: {{ amazee_header.personal_area.link_text }}, {{ amazee_header.personal_area.link_href }}'),
        
        'link_text' => [
            '#type' => 'textfield',
            '#title' => t('Link text'),
            '#default_value' => theme_get_setting('amazee_header.personal_area.link_text'),
            '#description' => t('Example: "Personal area".')
        ],
        
        'link_href' => [
            '#type' => 'textfield',
            '#title' => t('Link absolute path'),
            '#default_value' => theme_get_setting('amazee_header.personal_area.link_href'),
            '#description' => t('Provide an absolute internal link. Example: "/user".')
        ]
    ];
    
    $form['amazee_header']['phone'] = [
        '#type' => 'fieldset',
        '#tree' => TRUE,
        '#title' => t('Telephone'),
        '#description' => t('Usage: {{ amazee_header.phone.link_text }}, {{ amazee_header.phone.link_href }}'),
        
        'link_text' => [
            '#type' => 'textfield',
            '#title' => t('Displayable text'),
            '#default_value' => theme_get_setting('amazee_header.phone.link_text'),
            '#description' => t('Example: "+3138 230 15 03"')
        ],
        
        'link_href' => [
            '#type' => 'textfield',
            '#title' => t('Phone to pass as a link'),
            '#default_value' => theme_get_setting('amazee_header.phone.link_href'),
            '#description' => t('Provide phone using general format +31382301503')
        ]
    ];
}