<?php
/**
 * Calculates PayPal attendance totals for a specified event (ie, how many
 * are going, not going, etc).
 *
 * Also has the capability to print this information as HTML, intended for
 * use in the attendee summary screen.
 *
 * Note that the totals are calculated upon instantiation, effectively making
 * the object a snapshot in time. Therefore if the status of PayPal Tickets is modified
 * or if PayPal Tickets are added/deleted later in the request, it would be necessary
 * to obtain a new object of this type to get accurate results.
 */
class Tribe__Tickets__Commerce__PayPal__Attendance_Totals extends Tribe__Tickets__Abstract_Attendance_Totals {
	protected $total_sold = 0;
	protected $total_complete = 0;
	protected $total_pending = 0;

	/**
	 * Calculate totals for the current event.
	 *
	 * @since 4.7
	 */
	protected function calculate_totals() {
		foreach ( Tribe__Tickets__Tickets::get_event_tickets( $this->event_id ) as $ticket ) {
			if ( ! $this->should_count( $ticket ) ) {
				continue;
			}

			$this->total_sold += $ticket->qty_sold();
			$this->total_pending += $ticket->qty_pending();
		}

		$this->total_complete = $this->total_sold;
	}

	/**
	 * Indicates if the ticket should be factored into our sales counts.
	 *
	 * @since 4.7
	 *
	 * @param Tribe__Tickets__Ticket_Object $ticket
	 *
	 * @return bool
	 */
	protected function should_count( Tribe__Tickets__Ticket_Object $ticket ) {
		$should_count = 'Tribe__Tickets__RSVP' !== $ticket->provider_class;

		/**
		 * Determine if the provided ticket object should be used when building
		 * sales counts.
		 *
		 * By default, tickets belonging to the Tribe__Tickets__RSVP provider
		 * are not to be counted.
		 *
		 * @since 4.7
		 *
		 * @param bool $should_count
		 * @param Tribe__Tickets__Ticket_Object $ticket
		 */
		return (bool) apply_filters( 'tribe_tickets_should_use_ticket_in_sales_counts', $should_count, $ticket );
	}

	/**
	 * Prints an HTML (unordered) list of attendance totals.
	 *
	 * @since 4.7
	 */
	public function print_totals() {
		$total_sold_label = esc_html_x( 'Total Tickets Sold:', 'attendee summary', 'event-tickets' );
		$total_paid_label = esc_html_x( 'Complete:', 'attendee summary', 'event-tickets' );

		$total_sold = $this->get_total_sold();
		$total_paid = $this->get_total_complete();

		echo "
			<ul>
				<li> <strong>$total_sold_label</strong> $total_sold </li>
				<li> $total_paid_label $total_paid </li>
			</ul>
		";
	}

	/**
	 * Avoid render the total if ET+ is active as this is added by Tribe__Tickets_Plus__Commerce__Attendance_Totals
	 * otherwise go with regular flow provided by the parent.
	 *
	 * @since 4.7.1
	 */
	public function integrate_with_attendee_screen() {

		if ( class_exists( 'Tribe__Tickets_Plus__Commerce__Attendance_Totals' ) ) {
			return;
		}

		parent::integrate_with_attendee_screen();
	}

	/**
	 * The total number of tickets sold for this event.
	 *
	 * @since 4.7
	 *
	 * @return int
	 */
	public function get_total_sold() {
		/**
		 * Returns the total tickets sold for an event.
		 *
		 * @since 4.7
		 *
		 * @param int $total_sold
		 * @param int $original_total_sold
		 * @param int $event_id
		 */
		return (int) apply_filters( 'tribe_tickets_get_total_sold', $this->total_sold, $this->total_sold, $this->event_id );
	}

	/**
	 * The total number of tickets pending further action for this event.
	 *
	 * @since 4.7
	 *
	 * @return int
	 */
	public function get_total_pending() {
		/**
		 * Returns the total tickets pending further action for an event.
		 *
		 * @since 4.7
		 *
		 * @param int $total_pending
		 * @param int $original_total_pending
		 * @param int $event_id
		 */
		return (int) apply_filters( 'tribe_tickets_get_total_pending', $this->total_pending, $this->total_pending, $this->event_id );
	}

	/**
	 * The total number of tickets sold and paid for, for this event.
	 *
	 * @since 4.7
	 *
	 * @return int
	 */
	public function get_total_complete() {
		/**
		 * Returns the total tickets sold and paid for, for an event.
		 *
		 * @since 4.7
		 *
		 * @param int $total_complete
		 * @param int $original_total_complete
		 * @param int $event_id
		 */
		return (int) apply_filters( 'tribe_tickets_get_total_paid', $this->total_complete, $this->total_complete, $this->event_id );
	}
}