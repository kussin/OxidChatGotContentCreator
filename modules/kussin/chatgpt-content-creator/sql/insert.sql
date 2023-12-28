CREATE TABLE `kussin_chatgpt_content_creator_queue`
(
    `id`          INT(10) NOT NULL AUTO_INCREMENT,
    `object`      VARCHAR(55) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
    `object_id`   CHAR(32) NULL DEFAULT NULL COMMENT 'OXID of the corresponding object' COLLATE 'utf8_unicode_ci',
    `field`       VARCHAR(55) NULL DEFAULT NULL COMMENT 'DB Table Field or OXID Attribute' COLLATE 'utf8_unicode_ci',
    `shop_id`     INT(11) NOT NULL DEFAULT '1',
    `lang_id`     INT(11) NOT NULL DEFAULT '0',
    `content`     TEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
    `prompt`      TEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
    `model`       VARCHAR(55) NOT NULL DEFAULT 'gpt-3.5-turbo-instruct' COMMENT 'ChatGPT API Model' COLLATE 'utf8_unicode_ci',
    `max_tokens`  INT(5) NOT NULL DEFAULT '350' COMMENT 'ChatGPT API Max Tokens',
    `temperature` DOUBLE      NOT NULL DEFAULT '0.7' COMMENT 'ChatGPT API Temperature',
    `generated`   TEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
    `process_ip`  VARCHAR(55) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
    `status`      VARCHAR(16) NOT NULL DEFAULT 'pending' COLLATE 'utf8_unicode_ci',
    `created_at`  DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX         `id` (`id`) USING BTREE,
    INDEX         `object_id` (`object_id`) USING BTREE,
    INDEX         `object` (`object`) USING BTREE,
    INDEX         `status` (`status`) USING BTREE,
    INDEX         `field` (`field`) USING BTREE
) COLLATE='utf8_unicode_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1
;
