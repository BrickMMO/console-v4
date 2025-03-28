<?php

$filename = basename(__FILE__);

$length = radio_length($filename);

$prompt = 'Write a script for a '.$length.' minute radio segment. 

The radio station name is Lively Radio. 
There is one host for the radio station.'; 

// get host
$prompt .= host_prompt($_GET['key'], $filename);

$prompt .=' Only include the words the host will say, no instructions, no music or sounds. Please generate an audio based on the topic: commerical.';


$prompt .= 'We have two business partners: Watts Water Technologies, Inc and Loot Crypto Coin.

Choose one of the following two at random and write a script based on the introduction using radio speaking style. 

Watts Water Technologies, Inc. is a leading global provider of innovative products and solutions focused on plumbing, heating, and water quality systems. Established in 1874 by Joseph Watts, the company has grown to serve residential, commercial, industrial, and municipal markets worldwide. Watts offers a comprehensive portfolio of products, including water heaters, valves, filtration systems, and drainage solutions, all designed to promote sustainability, energy efficiency, and water conservation. Headquartered in North Andover, Massachusetts, Watts Water Technologies is committed to improving the comfort, safety, and performance of water systems globally.

Loot Crypto Coin refers to the ecosystem tokens associated with the Loot Project, a pioneering decentralized NFT initiative. Loot was created by Dom Hofmann in 2021, initially as a collection of 8,000 text-based NFTs, each representing randomly generated adventurer gear for gaming and storytelling. These NFTs serve as a foundation for community-driven projects in gaming, DeFi, and metaverse applications.
Within the Loot ecosystem, various coins and tokens may be developed to enable in-game economies, reward systems, or governance. The most prominent token associated with Loot is Adventure Gold (AGLD), introduced as a governance and utility token for the Loot community. AGLD was distributed freely to Loot NFT holders and has since been used to power ecosystem development, enabling players and creators to collaboratively expand the Loot universe..

';
