SELECT DISTINCT
    'oxartextends' AS `object`,
    oxartextends.OXID AS `object_id`,
    'oxlongdesc' AS `field`,
    oxarticles.OXSHOPID AS `shop_id`,
    0 AS `lang_id`,
    'pending' AS `status`
FROM
    oxartextends
LEFT JOIN
    oxarticles
ON
    (oxartextends.OXID = oxarticles.OXID)
WHERE
    (oxarticles.OXPARENTID = '')
    AND (LENGTH(oxartextends.OXLONGDESC) < 250)
ORDER BY
    oxarticles.OXTIMESTAMP DESC;