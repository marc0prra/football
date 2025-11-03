<?php

namespace src\Model;

enum StaffRole: string
{
    case Médecin = 'Médecin';
    case Entraineur = 'Entraineur';
    case Selectionneur = 'Selectionneur';
    case Consultant = 'Consultant';
}
