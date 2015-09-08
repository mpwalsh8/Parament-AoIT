<?php
/**
 * The use of this snippet requires at least WooCommerce 2.2
 */

/**
 * Alter the column headers for the orders CSV to split item_meta into separate columns
 *
 * Note that this change is only applied to the Default - One Row per Item format
 *
 * @param array $column_headers {
 *     column headers in key => name format
 *     to modify the column headers, ensure the keys match these and set your own values
 * }
 * @param WC_Customer_Order_CSV_Export_Generator $csv_generator, generator instance
 * @return array column headers in column_key => column_name format
 */
function sv_wc_csv_export_order_headers_split_item_meta( $column_headers, $csv_generator ) {

	if ( 'default_one_row_per_item' === $csv_generator->order_format ) {

		// remove item_meta column
		unset( $column_headers['item_meta'] );

		// get all item meta
		$all_item_meta = sv_wc_get_item_meta_for_orders( $csv_generator->ids );

		$item_meta_headers = array();

		foreach ( $all_item_meta as $meta_key ) {
			$item_meta_headers[ $meta_key ] = $meta_key;
		}

		$column_headers = sv_wc_array_insert_after( $column_headers, 'item_total', $item_meta_headers );
	}

	return $column_headers;
}
add_filter( 'wc_customer_order_csv_export_order_headers', 'sv_wc_csv_export_order_headers_split_item_meta', 10, 2 );


/**
 * CSV Order Export Line Item.
 *
 * Filter the individual line item entry to add the raw item for use in sv_wc_csv_export_order_row_one_row_per_item_split_item_meta()
 *
 * @param array $line_item {
 *     line item data in key => value format
 *     the keys are for convenience and not used for exporting. Make
 *     sure to prefix the values with the desired line item entry name
 * }
 *
 * @param array $item WC order item data
 * @return array $line_item
 */
function sv_wc_csv_export_order_line_item_add_raw_item( $line_item, $item, $product, $order, $csv_generator ) {
	if ( 'default_one_row_per_item' === $csv_generator->order_format ) {
		$line_item = array_merge( $line_item, array( 'raw_item' => $item ) );
	}
	return $line_item;
}
add_filter( 'wc_customer_order_csv_export_order_line_item', 'sv_wc_csv_export_order_line_item_add_raw_item', 10, 5 );


/**
 * CSV Order Export Row for One Row per Item.
 *
 * Filter the individual row data for the order export to add data for each item meta key
 *
 * @param array $order_data {
 *     order data in key => value format
 *     to modify the row data, ensure the key matches any of the header keys and set your own value
 * }
 * @param array $item
 * @param \WC_Order $order WC Order object
 * @param \WC_Customer_Order_CSV_Export_Generator $csv_generator, generator instance
 */
function sv_wc_csv_export_order_row_one_row_per_item_split_item_meta( $order_data, $item, $order, $csv_generator ) {

	$item_meta = new WC_Order_Item_Meta( $item['raw_item']['item_meta'] );

	foreach ( $item_meta->get_formatted() as $meta_key => $values ) {
		$order_data[ $meta_key ] = $values['value'];
	}

	return $order_data;
}
add_filter( 'wc_customer_order_csv_export_order_row_one_row_per_item', 'sv_wc_csv_export_order_row_one_row_per_item_split_item_meta', 10, 4 );


/** Helper Functions **********************************************************/

/**
 * Get item meta for orders
 *
 * @param array $order_ids array of order ids
 * @return array $all_item_meta array of all item meta keys for $order_ids
 */
function sv_wc_get_item_meta_for_orders( $order_ids ) {

	$all_item_meta = array();

	foreach ( $order_ids as $order_id ) {

		$order = wc_get_order( $order_id );

		// get line items
		foreach ( $order->get_items() as $item ) {
			$item_meta = new WC_Order_Item_Meta( $item['item_meta'] );
			$all_item_meta = array_merge( $all_item_meta, array_keys( $item_meta->get_formatted() ) );
		}
	}

	return $all_item_meta;
}

/**
 * Insert the given element after the given key in the array
 *
 * @param array $array array to insert the given element into
 * @param string $insert_key key to insert given element after
 * @param array $element element to insert into array
 * @return array
 */
function sv_wc_array_insert_after( Array $array, $insert_key, Array $element ) {

	$new_array = array();

	foreach ( $array as $key => $value ) {

		$new_array[ $key ] = $value;

		if ( $insert_key == $key ) {

			foreach ( $element as $k => $v ) {
				$new_array[ $k ] = $v;
			}
		}
	}

	return $new_array;
}
