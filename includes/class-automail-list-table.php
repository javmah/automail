<?php
/**
 * Define the internationalization functionality.
 * Loads and defines the internationalization files for this plugin
 *
 * @since      1.0.0
 * @package    Wpgsi
 * @subpackage Wpgsi/includes
 * @author     javmah <jaedmah@gmail.com>
*/
if(!class_exists('WP_List_Table')) require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

# Plugin class extends.
class Automail_List_Table extends WP_List_Table {

    
    public $eventsAndTitles ;

   /**
   * Construct function
   * Set default settings.
   * @since      1.0.0
   */
    function __construct( $eventsAndTitles ) {
        global $status, $page;
        $this->eventsAndTitles = $eventsAndTitles;
        //Set parent defaults
        parent::__construct(array(
            'ajax'     => FALSE,
            'singular' => 'user',
            'plural'   => 'users',
        ));
    }
    
   /**
   * Renders the columns.
   * @since 1.0.0
   */
    public function column_default( $item, $column_name ) {
        $post_excerpt = unserialize( $item->post_excerpt );
        $post_content = '';

        switch ($column_name) {
            case 'id':
                $value = $item->ID;
                break;
            case 'automatonName':
                $value = $item->post_title;
                break;
            case 'AutomatonEvent': 
                $value = $post_excerpt->Data_source ;
                break;
            case 'emailReceiver':
                $value = $post_excerpt->Worksheet ;
                break;
            case 'status':
                $value =  $item->post_status;
                break;
            default:
                $value = '--';
        }
    }

    /**
     * Retrieve the table columns.
     * @since 1.0.0
     * @return array $columns Array of all the list table columns.
     */
    public function get_columns() {
        $columns = array(
            'cb'                 => '<input type="checkbox" />',
            'automatonName'      => esc_html__( 'Automaton Name',   'automail' ),
            'AutomatonEvent'     => esc_html__( 'Automaton Event',  'automail' ),
            'emailReceiver'      => esc_html__( 'Email Receiver',   'automail' ),
            'status'             => esc_html__( 'Status',           'automail' )
        );
        return $columns;
    }

    /**
	 * Render the checkbox column.
	 * @since      1.0.0
	 * @return     array   	 This Function Will return an array 
	*/
    public function column_cb( $item ) {
        return '<input type="checkbox" name="id[]" value="' . absint( $item->ID ) . '" />';
    }

    /**
	 * Define bulk actions available for our table listing.
	 * @since      1.0.0
	 * @return     array   	 This Function Will return an array 
	*/
    public function get_bulk_actions() {
        $actions = array(
            'delete' => esc_html__( 'Delete', 'automail' ),
        );
        return $actions;
    }
    
    /**
	 * This Function Should be Remove || Use automail_delete_connection function in automail admin class Process the bulk actions.
	 * @since      1.0.0
	 * @return     array   	 This Function Will return an array 
	*/
    public function process_bulk_actions() {
        # getting the ids
        // $ids = isset( $_GET['id'] ) ? $_GET['id'] : array();
        // # security and ID Check 
        // if ( $this->current_action() == 'delete' && wp_verify_nonce( $_GET['automail_nonce'], 'automail_nonce_bulk_action' ) && ! empty( $ids )  ) {
        //     # Loop the Ids
        //     foreach ( $ids as $id ) {
        //         wp_delete_post( $id );
        //     }
        // }

        #***************************************************************************************************
        # Bulk Action is Processes in >> class_automail_admin.php >> automail_menu_pages_view() function 
        #***************************************************************************************************
        # This Function is useless now 
        #***************************************************************************************************
    }

    /**
	 * --------------------------------------------------------
	 * @since      1.0.0
	 * @return     array   	 This Function Will return an array 
	*/
    public function column_AutomatonEvent( $item ) {
        if ( $item->post_excerpt ) {
            return esc_attr( $item->post_excerpt );
        } else {
            _e( "Not Set !" , "automail" );
        }
    }

    /**
	 * --------------------------------------------------------
	 * @since      1.0.0
	 * @return     array   	 This Function Will return an array 
	*/
    public function column_emailReceiver( $item ) {
        $mailReceiverArray =  get_post_meta( $item->ID, 'mailReceiver', TRUE );
        echo json_encode( $mailReceiverArray );
    }

    /**
	 * Render the form name column with action links.
	 * @since      1.0.0
	 * @return     array   	 This Function Will return an array 
	*/
    public function column_automatonName( $item ) {
        $name = ! empty( $item->post_title ) ? $item->post_title : '--';
        $name = sprintf( '<span><strong>%s</strong></span>', esc_html__( $name ) );
        # Build all of the row action links.
        $row_actions = array();
        # Edit.
        $row_actions['edit'] = sprintf(
            '<a href="%s" title="%s">%s</a>',
            add_query_arg(
                array(
                    'action' => 'edit',
                    'id'     => $item->ID,
                ),
                admin_url( 'admin.php?page=automail' )
            ),
            esc_html__( 'Edit This Relation', 'automail' ),
            esc_html__( 'Edit', 'automail' )
        );

        # Delete.
        $row_actions['delete'] = sprintf(
            '<a href="%s" class="relation-delete" title="%s">%s</a>',
            wp_nonce_url(
                add_query_arg(
                    array(
                        'action' => 'delete',
                        'id'     => $item->ID,
                    ),
                    admin_url( 'admin.php?page=automail' )
                ),
                'automail_delete_relation_nonce'
            ),
            esc_html__( 'Delete this relation', 'automail' ),
            esc_html__( 'Delete', 'automail' )
        );

        # Build the row action links and return the value.
        return $name . $this->row_actions( apply_filters( 'fts_relation_row_actions', $row_actions, $item ) );
    }

    /**
	 * Message to be displayed when there are no relations.
	 * @since      1.0.0
	 * @return     array   	 This Function Will return an array 
	*/
    public function column_status( $item ) {
        if ( $item->post_status == 'publish' ) {
            $actions = "<br><span title='Enable or Disable this Automation'  onclick='window.location=\"admin.php?page=automail&action=status&id=" . $item->ID . "\"'  class='a_activation_checkbox'  ><a class='a_activation_checkbox' href='?page=automail&action=edit&id=".$item->ID."'>  <input type='checkbox' name='status' checked=checked > </a></span>" ;
        } else {
            $actions = "<br><span title='Enable or Disable this Automation' onclick='window.location=\"admin.php?page=automail&action=status&id=" . $item->ID . " \"'  class='a_activation_checkbox'  ><a class='a_activation_checkbox' href='?page=automail&action=edit&id=".$item->ID."'>  <input type='checkbox' name='status' > </a></span>" ;
        }
        $actions .= "<br><br> <a href='" . admin_url() . "admin.php?page=automail&action=columnTitle&id=" . $item->ID . " ' class='dashicons dashicons-controls-repeat' title='Test Fire ! Please check your Google Spreadsheet for effects' ></a>";

        return   $actions ;
    }

    /**
	 * Message to be displayed when there are no relations.
	 * @since      1.0.0
	 * @return     array   	 This Function Will return an array 
	*/
    public function no_items() {
        printf(
            wp_kses(
                __( 'Whoops, you haven\'t created a relation yet. Want to <a href="%s">give it a go</a>?', 'automail' ),
                array(
                    'a' => array(
                        'href' => array(),
                    ),
                )
            ),
            admin_url( 'admin.php?page=automail&action=new' )
        );
    }

    /**
	 * Sortable settings.
	 * @since      1.0.0
	 * @return     array   	 This Function Will return an array 
	*/
    public function get_sortable_columns() {
        return array(
            'automatonName'     => array('automatonName', TRUE),
            'AutomatonEvent'    => array('AutomatonEvent', TRUE),
            'status'            => array('status', TRUE),
        );
    }

    /**
	 * Fetching Data from Database  
	 * @since      1.0.0
	 * @return     array   	 This Function Will return an array 
	*/
    public function fetch_table_data() {
        return get_posts( array( 
            'post_type'         =>  'automail',
            'post_status'       =>  'any',
            'posts_per_page'    =>  -1 ,
        )); 
    }

    /**
	 * Query, filter data, handle sorting, pagination, and any other data-manipulation required prior to rendering 
	 * @since      1.0.0
	 * @return     array   	 This Function Will return an array 
	*/
    public function prepare_items() {
        # Process bulk actions if found.
        $this->process_bulk_actions();
        # Defining Values
        $per_page              = 20;
        $count                 = $this->count();
        $columns               = $this->get_columns();
        $hidden                = array();
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $table_data            = $this->fetch_table_data();
        $this->items           = $table_data;
        $this->admin_header();

        $this->set_pagination_args(
            array(
                'total_items' => $count,
                'per_page'    => $per_page,
                'total_pages' => ceil( $count / $per_page ),
            )
        );
    }

    /**
	 * Count Items for Pagination 
	 * @since      1.0.0
	 * @return     array   	 This Function Will return an array 
	*/
    public function count() {
        $automail_posts = get_posts( array( 
            'post_type'     => 'automail',
            'post_status'   => 'any',
            'posts_per_page'=> -1,
        )); 
        return count($automail_posts);
    }

    /**
	 * This Function Will return all the Save integrations from database 
	 * @since      3.4.0
	 * @return     array   	 This Function Will return an array 
	*/
	public function automail_getIntegrations( ) {
		# Setting Empty Array
		$integrationsArray 	 = array();
		# Getting All Posts
		$listOfConnections   =  get_posts( array(
			'post_type'   	 => 'automail',
			'post_status' 	 =>  array('publish', 'pending'),
			'posts_per_page' =>  -1
		));

		# integration loop starts
		foreach ( $listOfConnections as $key => $value ) {
			# Compiled to JSON String 
			$post_excerpt = json_decode( $value->post_excerpt, TRUE );
			# if JSON Compiled successfully 
			if ( is_array( $post_excerpt ) AND !empty( $post_excerpt ) ) {
				$integrationsArray[$key]["IntegrationID"] 	= $value->ID;
				$integrationsArray[$key]["DataSource"] 		= $post_excerpt["DataSource"];
				$integrationsArray[$key]["DataSourceID"] 	= $post_excerpt["DataSourceID"];
				$integrationsArray[$key]["Worksheet"] 		= $post_excerpt["Worksheet"];
				$integrationsArray[$key]["WorksheetID"] 	= $post_excerpt["WorksheetID"];
				$integrationsArray[$key]["Spreadsheet"] 	= $post_excerpt["Spreadsheet"];
				$integrationsArray[$key]["SpreadsheetID"] 	= $post_excerpt["SpreadsheetID"];
				$integrationsArray[$key]["Status"] 			= $value->post_status;
			} else {
				# Display Error, Because Data is corrected or Empty 
			}
		}

		# integration loop Ends
		# return  array with First Value as Bool and second one is integrationsArray array
		if ( count( $integrationsArray ) ) {
			return array( TRUE, $integrationsArray );
		} else {
			return array( FALSE, $integrationsArray );
		}
	}

    /**
	 * Display Table CSS, Admin table style 
	 * @since      1.0.0
	 * @return     array   	 This Function Will return an array 
	*/
    public function admin_header() {
        $page = ( isset($_GET['page'] ) ) ? esc_attr( $_GET['page'] ) : false;
        # if another page redirect user;
        if ( 'automail' != $page ){
            return;
        }
        
        echo '<style type="text/css">';
        echo '.wp-list-table .column-id { width: 10%; }';
        echo '.wp-list-table .column-automatonName { width: 35%; }';
        echo '.wp-list-table .column-AutomatonEvent { width: 15%; }';
        echo '.wp-list-table .column-emailReceiver { width: 30%; }';
        echo '.wp-list-table .column-status { width: 10%; }';
        echo '</style>';
    }
}


