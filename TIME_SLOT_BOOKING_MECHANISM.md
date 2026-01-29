# Time-Slot Based Booking Mechanism

## Overview
The booking system has been updated from table-based booking to time-slot based booking. Instead of marking entire tables as booked, the system now disables specific date and time slots for particular tables.

## Key Changes

### 1. Meja Model Updates
- **New Method**: `isTimeSlotAvailable($date, $startTime, $duration)` - Checks if a specific time slot is available
- **New Method**: `getBookedTimeSlotsForDate($date)` - Gets all booked time slots for a specific date
- **New Method**: `getAvailableTimeSlotsForDate($date, $duration)` - Gets all available time slots for a specific date and duration
- **Updated Method**: `isBooked()` - Still works for general availability checking
- **Updated Methods**: Booking status methods now show "partially_booked" for tables with some time slots booked

### 2. BookingController Updates
- **Updated Method**: `getAvailableTimes()` - Now returns structured available/booked slots data
- **New Method**: `checkTimeSlotAvailability()` - Validates specific time slot availability
- **Updated Method**: `processBooking()` - Now validates time slot availability before creating booking

### 3. Frontend Updates
- Time selection now considers duration when showing available slots
- Real-time availability checking based on selected date and duration
- Better user feedback for unavailable time slots

## How It Works

### Time Slot Availability Logic
1. **Operating Hours**: 08:00 - 22:00 (configurable in Meja model)
2. **Slot Duration**: Based on user selection (1-8 hours)
3. **Conflict Detection**: Uses time overlap detection to prevent double bookings
4. **Status Filtering**: Only considers paid/pending bookings that are not completed/cancelled

### Booking Process
1. User selects date and duration
2. System fetches available time slots for that date/duration combination
3. User selects start time from available options
4. System validates availability before creating transaction
5. If slot becomes unavailable during booking, user gets error message

### API Endpoints

#### Get Available Time Slots
```
GET /pelanggan/meja/{id}/available-times?date={date}&duration={duration}
```

**Response:**
```json
{
    "success": true,
    "available_slots": [
        {
            "time": "08:00",
            "display": "08:00 - 09:00",
            "available": true
        },
        {
            "time": "09:00",
            "display": "09:00 - 10:00",
            "available": false
        }
    ],
    "booked_slots": [
        {
            "start": "09:00",
            "end": "11:00",
            "duration": 2,
            "booking_id": 123
        }
    ]
}
```

#### Check Specific Time Slot
```
POST /pelanggan/meja/{id}/check-time-slot
```

**Request:**
```json
{
    "date": "2025-01-30",
    "time": "14:00",
    "duration": 2
}
```

**Response:**
```json
{
    "success": true,
    "available": true,
    "date": "2025-01-30",
    "time": "14:00",
    "duration": 2
}
```

## Benefits

1. **More Flexible**: Customers can book specific time slots instead of entire days
2. **Better Utilization**: Tables can be used by multiple customers on the same day
3. **Accurate Availability**: Real-time checking prevents double bookings
4. **User-Friendly**: Shows exact available time slots based on desired duration
5. **Conflict Prevention**: Automatic validation prevents overlapping bookings

## Database Schema
No database changes required. The existing `transaksis` table with `tanggal_booking`, `jam_mulai`, and `durasi` fields provides all necessary data for time slot calculations.

## Configuration
Operating hours can be configured in the Meja model:
```php
// In getAvailableTimeSlotsForDate method
$openingHour = 8;  // 08:00
$closingHour = 22; // 22:00
```

## Testing
To test the new mechanism:
1. Create some bookings for specific time slots
2. Try booking overlapping time slots (should be prevented)
3. Check that available time slots update correctly based on duration
4. Verify that completed/cancelled bookings don't block time slots