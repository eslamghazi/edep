<?php

namespace App\Services;

use App\Models\Ticket;
use App\Repositories\TicketRepository;
use Illuminate\Database\Eloquent\Collection;

class TicketService
{
    public function __construct(protected TicketRepository $ticketRepository)
    {
    }

    public function getAllTickets(): Collection
    {
        return $this->ticketRepository->getAllTicket();
    }

    public function getTicketById($id): ?Ticket
    {
        return $this->ticketRepository->getTicketById($id);
    }

    public function createTicket($data): Ticket
    {
        return $this->ticketRepository->createTicket($data);
    }

    public function updateTicket($id, array $data): ?Ticket
    {
        $ticket = $this->ticketRepository->getTicketById($id);
        if (!$ticket) {
            return null;
        }
        $this->ticketRepository->updateTicket($ticket, $data);
        return $ticket;
    }

    public function deleteTicket($id): ?Ticket
    {
        $ticket = $this->ticketRepository->getTicketById($id);
        if (!$ticket) {
            return null;
        }
        $this->ticketRepository->deleteTicket($ticket);
        return $ticket;
    }

    public function sendNewTicketSms(Ticket $ticket)
    {
        return $this->ticketRepository->sendNewTicketSms($ticket);
    }

    public function sendCloseCodeSms(Ticket $ticket, $phone = null)
    {
        return $this->ticketRepository->sendCloseCodeSms($ticket, $phone);
    }

    public function sendReviewSms(Ticket $ticket)
    {
        return $this->ticketRepository->sendReviewSms($ticket);
    }
}
