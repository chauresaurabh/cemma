"This function converts the numerical weekday to English weekday";
sub convert_weekday {
	local ($weekday) = @_;
	if($weekday == 1|$weekday eq '01')
	{
		return 'Monday';
	}elsif
	($weekday == 2|$weekday eq '02')
	{
		return 'Tuesday';
	}elsif($weekday ==3|$weekday eq '03')
	{
		return 'Wednesday';
	}elsif
	($weekday == 4 |$weekday eq '04')
	{
		return 'Thursday';
	}elsif($weekday ==5|$weekday eq '05')
	{
		return 'Friday';
	}elsif
	($weekday ==6|$weekday eq '06')
	{
		return 'Saturday';
	}elsif($weekday == 0)
	{
		return 'Sunday';
	}
}
