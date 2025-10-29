<?php

namespace App\Repositories;

use App\Models\Ticket;
use App\Gateways\Dreamsa;
use Illuminate\Database\Eloquent\Collection;

class TicketRepository
{
    public function getAllTicket(): Collection
    {
        return Ticket::all();
    }

    public function getTicketById($id): ?Ticket
    {
        return Ticket::findOrFail($id);
    }

    public function createTicket(array $data): Ticket
    {
        return Ticket::create($data);
    }

    public function updateTicket(Ticket $ticket, array $data): void
    {
        $ticket->update($data);
    }

    public function deleteTicket(Ticket $ticket): void
    {
        $ticket->delete();
    }

    public function sendNewTicketSms(Ticket $ticket)
    {
        $smsMessage = "تم انشاء طلب صيانة للآلة رقم {$ticket->printer_code}.
        رقم الطلب {$ticket->ticket_code}.";

        $sms = new Dreamsa();
        $sms->send($smsMessage, trim($ticket->phone));
        $sms->send($smsMessage, "966547055710");
        $sms->send($smsMessage, "966554843474");
    }

    public function sendCloseCodeSms(Ticket $ticket, $phone = null)
    {
        $smsMessage = "لإغلاق طلب الصيانة رقم {$ticket->ticket_code} استخدم الكود {$ticket->close_code}";

        $sms = new Dreamsa();
        // Use provided phone or default to ticket phone
        $recipientPhone = $phone ?? $ticket->phone;
        $sms->send($smsMessage, trim($recipientPhone));
    }
}
