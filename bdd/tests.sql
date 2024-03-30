SELECT a.idAddress, a.streetNumber, a.streetName, city.cityName, city.addressCode
FROM Company company
JOIN is_settle s ON (company.idCompany = s.idCompany)
JOIN Address a ON (s.idAddress = a.idAddress)
JOIN City city ON (a.idCity = city.idCity)
WHERE company.idCompany = 1;

SELECT * FROM Company
INNER JOIN is_settle ON Company.idCompany = is_settle.idCompany
INNER JOIN Address ON is_settle.idAddress = Address.idAddress
INNER JOIN City ON Address.idCity = City.idCity;

SELECT * FROM Address
INNER JOIN City ON Address.idCity = City.idCity;