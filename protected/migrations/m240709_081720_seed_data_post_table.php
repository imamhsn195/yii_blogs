<?php

class m240709_081720_seed_data_post_table extends CDbMigration
{
	public function up()
	{
        $isSeed = true; //isset($_GET['seed']);

        if ($isSeed) {
            // Fetch URLs and insert data
            $urls = $this->fetch_urls();
            if ($urls !== null) {
                foreach ($urls as $url) {
                    list($title, $bannerImage, $content, $createdDate, $updatedDate) = $this->fetch_data($url);
                    if ($title && $content) {
                        $this->insert_data($url, $title, $bannerImage, $content, $createdDate, $updatedDate);
                    }
                }
                echo "Post data inserted into the database successfully.\n";
            } else {
                echo "No URLs fetched.";
            }
        } else {
            echo "Skipping seeding data as --seed flag is not set.";
        }

	}

	public function down()
	{
		echo "m240709_081720_seed_data_post_table does not support migration down.\n";
		return false;
	}

	// Function to fetch URLs from the website
	function fetch_urls() {
		$url = 'https://www.khaleejtimes.com/uae';
		$response = file_get_contents($url);
		if ($response !== false) {
			$doc = new DOMDocument();
			libxml_use_internal_errors(true); // Disable libxml errors
			$doc->loadHTML($response);
			$xpath = new DOMXPath($doc);
			
			// Find all <h2 class="post-title"><a> elements and extract URLs
			$urls = [];
			$postTitles = $xpath->query('//h2[@class="post-title"]/a');
			
			// Limit to 100 URLs
			$count = 0;
			foreach ($postTitles as $title) {
				$urls[] = $title->getAttribute('href');
				$count++;
				if ($count >= 100) {
					break;
				}
			}
			
			echo "Posts seeder file is running...";
			return $urls;
		} else {
			echo "Failed to fetch $url\n";
			return null;
		}
	}

	// Function to fetch data from a URL
	function fetch_data($url) {
		$response = file_get_contents($url);
		if ($response !== false) {
			$doc = new DOMDocument();
			libxml_use_internal_errors(true); // Disable libxml errors
			$doc->loadHTML($response);
			$xpath = new DOMXPath($doc);
			
			// Extract title, banner image, content, created_at, updated_at as needed
			$title = $xpath->query('//title')->item(0)->nodeValue;
			
			// Find the image tag within the specified div
			$bannerImage = null;
			$imgTag = $xpath->query('//div[@class="article-lead-img-pan"]/img')->item(0);
			if ($imgTag) {
				$bannerImage = $imgTag->getAttribute('src');
			}
			
			$contentNodes = $xpath->query('//p');
			$content = '';
			foreach ($contentNodes as $node) {
				$content .= $node->nodeValue . ' ';
			}
			
			// Extract published and updated date/time if available
			$publishedDate = null;
			$updatedDate = null;
			$spanTags = $xpath->query('//span');
			foreach ($spanTags as $spanTag) {
				$text = trim($spanTag->nodeValue);
				if ($text == 'Published:') {
					$nextSibling = $spanTag->nextSibling;
					if ($nextSibling && $nextSibling->nodeName == 'span') {
						$publishedDate = DateTime::createFromFormat('D d M Y, h:i A', trim($nextSibling->nodeValue));
					}
				} elseif ($text == 'Last updated:') {
					$nextSibling = $spanTag->nextSibling;
					if ($nextSibling && $nextSibling->nodeName == 'span') {
						$updatedDate = DateTime::createFromFormat('D d M Y, h:i A', trim($nextSibling->nodeValue));
					}
				}
			}
			
			return array($title, $bannerImage, $content, $publishedDate, $updatedDate);
		} else {
			echo "Failed to fetch $url";
			return array(null, null, null, null, null);
		}
	}

	// Function to insert data into the database
	function insert_data($url, $title, $bannerImage, $content, $createdDate, $updatedDate) {
		try {
			$db = Yii::app()->db;

			// Insert data into the database
			$authorId = rand(1, 5);  // Generate random author_id from 1 to 5
			$isPublic = rand(0, 1);  // Generate random is_public (0 or 1)

			$command = $db->createCommand();
			$command->insert('post', array(
				'title' => $title,
				'content' => $content,
				'author_id' => $authorId,
				'is_public' => $isPublic,
				'image_url' => $bannerImage,
				'created_at' => $createdDate !== null ? $createdDate->format('Y-m-d H:i:s') : new CDbExpression('NOW()'),
				'updated_at' => $updatedDate !== null ? $updatedDate->format('Y-m-d H:i:s') : new CDbExpression('NOW()'),
			));
		} catch(Exception $e) {
			echo "Error: " . $e->getMessage();
		}
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}