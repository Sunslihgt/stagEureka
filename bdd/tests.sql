SELECT a.idAddress, a.streetNumber, a.streetName, city.cityName, city.addressCode
FROM Company company
JOIN is_settle s ON (company.idCompany = s.idCompany)
JOIN Address a ON (s.idAddress = a.idAddress)
JOIN City city ON (a.idCity = city.idCity)
WHERE company.idCompany = 1;