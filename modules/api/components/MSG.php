<?php

/**
 * Created by PhpStorm.
 * User: whwyy
 * Date: 2015/9/1 0001
 * Time: 10:37
 */
class MSG
{
	const ERROR_INFO    = '系统繁忙,请稍后再试';
	const SUCCESS_INFO  = '请求成功';
	const ERROR         = 'E505';
	const SUCCESS       = 'S200';

	public static $_return = array(
		self::ERROR => self::ERROR_INFO,
		self::SUCCESS => self::SUCCESS_INFO,
	);

	const HUASHU = '127.0.0.1';
	public static $ip = array(
		self::HUASHU
	);

	const XML = '<?xml version="1.0" encoding="UTF-8"?>
<adi:ADI2 xmlns="http://www.cablelabs.com/VODSchema/default" xmlns:adi="http://www.cablelabs.com/VODSchema/adi" xmlns:vod="http://www.cablelabs.com/VODSchema/vod">
  <adi:OpenGroupAsset type="VODRelease" product="VOD">
    <vod:VODRelease providerID="CP2301" providerType="2" assetID="CP23010020140626132000" updateNum="" groupAsset="Y" serialNo="2014071411520018">
      <adi:AssetLifetime startDateTime="2014-06-26" endDateTime="2064-06-26" />
    </vod:VODRelease>
  </adi:OpenGroupAsset>
  <adi:AddMetadataAsset groupProviderID="CP2301" groupAssetID="CP23010020140626132000" type="Title" product="VOD">
    <vod:Title providerID="CP2301" assetID="CP23010020140626132000" updateNum="1">
      <adi:AssetLifetime startDateTime="2014-06-26" endDateTime="2064-06-26" />
      <vod:Format />
      <vod:StarLevel>0</vod:StarLevel>
      <vod:Keyword>励志 微电影</vod:Keyword>
      <vod:IsAdvertise>0</vod:IsAdvertise>
      <vod:Background />
      <vod:Year>2014</vod:Year>
      <vod:StudioName />
      <vod:Actor type="Actor">
        <vod:LastNameFirst>李琛,陈羽琦,廖望</vod:LastNameFirst>
      </vod:Actor>
      <vod:RunTime />
      <vod:Actor type="Actress">
        <vod:LastNameFirst />
      </vod:Actor>
      <vod:Awards />
      <vod:Actor type="CoActress">
        <vod:LastNameFirst />
		</vod:Actor>
      <vod:MediaFormat />
      <vod:Director>
        <vod:LastNameFirst>李闻郅</vod:LastNameFirst>
      </vod:Director>
      <vod:CountryOfOrigin>1</vod:CountryOfOrigin>
      <vod:IptvDesc />
      <vod:Comments />
      <vod:TitleFull>更上一层楼</vod:TitleFull>
      <vod:Agent />
      <vod:Actor type="CoActor">
        <vod:LastNameFirst />
      </vod:Actor>
      <vod:ShowType>Movie</vod:ShowType>
      <vod:Priority>6</vod:Priority>
      <vod:Status>0</vod:Status>
      <vod:Rating />
      <vod:SummaryMedium>小帅、小丽和大勇，是生活在遥远山村子的小伙伴儿，三人从小便形影不离，是最要好的朋友。因为腿有残疾，童年的小帅常常感到自卑。他经常一个人坐着，看着小丽和大勇谂┐逄な档毓兆樱笄康男∷Р还烁改缸枥梗琶蜗牒豌裤剑胄±鲆黄鹛ど狭丝本┑幕鸪怠/vod:SummaryMedium>
      <vod:SummaryShort>反映北漂生活励志电影</vod:SummaryShort>
      <vod:Language>国语</vod:Language>
      <vod:Superviser />
      <vod:EnglishDesc />
    </vod:Title>
  </adi:AddMetadataAsset>
  <adi:AddMetadataAsset groupProviderID="CP2301" groupAssetID="CP23010020140626132000" type="CategoryPath" product="VOD">
    <vod:CategoryPath providerID="CP2301" assetID="CP23010020140626132000" updateNum="1">
      <adi:AssetLifetime startDateTime="2014-06-26" endDateTime="2064-06-26" />
      <vod:Category>文艺情感</vod:Category>
      <vod:Classification>电影类节目</vod:Classification>
    </vod:CategoryPath>
	</adi:AddMetadataAsset>
  <adi:AddMetadataAsset groupProviderID="CP2301" groupAssetID="CP23010020140626132000" type="Copyright" product="VOD">
    <vod:Copyright providerID="CP2301" assetID="CP23010020140626132000" updateNum="1">
      <adi:AssetLifetime startDateTime="2014-06-26" endDateTime="2064-06-26" />
      <vod:LicenseType>0</vod:LicenseType>
      <vod:TransferAgain>0</vod:TransferAgain>
      <vod:CopyType>1</vod:CopyType>
      <vod:OriginalLicenseCompany />
      <vod:Transfer3rd>0</vod:Transfer3rd>
      <vod:CopyName />
      <vod:PublishNo />
      <vod:AuthorserilNo />
      <vod:VideoLicense />
      <vod:CopyIdea />
      <vod:CountryNo />
      <vod:PublicationDate></vod:PublicationDate>
      <vod:CopyLicense />
      <vod:CopySerilNo />
      <vod:CopyLicenser />
      <vod:TransferLicenseCompany />
    </vod:Copyright>
  </adi:AddMetadataAsset>
  <adi:AcceptContentAsset type="Image" metadataOnly="N" fileName="更上一层楼_新家庭版大图片" fileSize="29836" mD5CheckSum="7c903052c72ca26e6921dbd668cbfee4">
    <vod:Image providerID="CP2301" assetID="CP23010020140626132003" updateNum="1" fileName="更上一层楼_新家庭版大图片" fileSize="29836" mD5CheckSum="7c903052c72ca26e6921dbd668cbfee4" transferContentURL="ftp://upload02:upload02@125.210.139.14:21/icds-Warehouse02/Pic/20140629/20140626233800_gengshangyicenglour_917304885.jpg" imageEncodingProfile="JPG/JPEG">
      <adi:AssetLifetime startDateTime="2014-06-26" endDateTime="2064-06-26" />
      <vod:Caption>更上一层楼_新家庭版大图片</vod:Caption>
      <vod:MimeType>25</vod:MimeType>
      <vod:FileType>3</vod:FileType>
      <vod:ServiceType>1</vod:ServiceType>
      <vod:ColorType>RGB</vod:ColorType>
	  <vod:Usage>17</vod:Usage>
      <vod:ImagePixels horizontalPixels="176" verticalPixels="342" />
    </vod:Image>
  </adi:AcceptContentAsset>
  <adi:AcceptContentAsset type="Image" metadataOnly="N" fileName="更上一层楼_新家庭版小图片" fileSize="53124" mD5CheckSum="3ba0f4cf2284eb7d7fcebb2032a3fd89">
    <vod:Image providerID="CP2301" assetID="CP23010020140626132006" updateNum="1" fileName="更上一层楼_新家庭版小图片" fileSize="53124" mD5CheckSum="3ba0f4cf2284eb7d7fcebb2032a3fd89" transferContentURL="ftp://upload02:upload02@125.210.139.14:21/icds-Warehouse02/Pic/20140629/20140626233800_gengshangyicenglouc_917304900.jpg" imageEncodingProfile="JPG/JPEG">
      <adi:AssetLifetime startDateTime="2014-06-26" endDateTime="2064-06-26" />
      <vod:Caption>更上一层楼_新家庭版小图片</vod:Caption>
      <vod:MimeType>25</vod:MimeType>
      <vod:FileType>3</vod:FileType>
      <vod:ServiceType>1</vod:ServiceType>
      <vod:ColorType>RGB</vod:ColorType>
      <vod:Usage>18</vod:Usage>
      <vod:ImagePixels horizontalPixels="257" verticalPixels="305" />
    </vod:Image>
  </adi:AcceptContentAsset>
  <adi:AcceptContentAsset type="Image" metadataOnly="N" fileName="更上一层楼_新家庭版大海报" fileSize="6477" mD5CheckSum="f5d0462dc740f5787f83328382ca0fdf">
    <vod:Image providerID="CP2301" assetID="CP23010020140626132002" updateNum="1" fileName="更上一层楼_新家庭版大海报" fileSize="6477" mD5CheckSum="f5d0462dc740f5787f83328382ca0fdf" transferContentURL="ftp://upload02:upload02@125.210.139.14:21/icds-Warehouse02/Pic/20140629/20140626233800_gengshangyicenglous_917304880.jpg" imageEncodingProfile="JPG/JPEG">
      <adi:AssetLifetime startDateTime="2014-06-26" endDateTime="2064-06-26" />
      <vod:Caption>更上一层楼_新家庭版大海报</vod:Caption>
      <vod:MimeType>25</vod:MimeType>
      <vod:FileType>3</vod:FileType>
      <vod:ServiceType>1</vod:ServiceType>
      <vod:ColorType>RGB</vod:ColorType>
      <vod:Usage>15</vod:Usage>
      <vod:ImagePixels horizontalPixels="138" verticalPixels="181" />
    </vod:Image>
  </adi:AcceptContentAsset>
  <adi:AcceptContentAsset type="Image" metadataOnly="N" fileName="更上一层楼_新家庭版海报" fileSize="119935" mD5CheckSum="ef02201fc21e8cc73ccc20263af47ce0">
  <vod:Image providerID="CP2301" assetID="CP23010020140626132004" updateNum="1" fileName="更上一层楼_新家庭版海报" fileSize="119935" mD5CheckSum="ef02201fc21e8cc73ccc20263af47ce0" transferContentURL="ftp://upload02:upload02@125.210.139.14:21/icds-Warehouse02/Pic/20140629/20140626233800_gengshangyicenglou_917304890.jpg" imageEncodingProfile="JPG/JPEG">
      <adi:AssetLifetime startDateTime="2014-06-26" endDateTime="2064-06-26" />
      <vod:Caption>更上一层楼_新家庭版海报</vod:Caption>
      <vod:MimeType>25</vod:MimeType>
      <vod:FileType>3</vod:FileType>
      <vod:ServiceType>1</vod:ServiceType>
      <vod:ColorType>RGB</vod:ColorType>
      <vod:Usage>6</vod:Usage>
      <vod:ImagePixels horizontalPixels="410" verticalPixels="543" />
    </vod:Image>
  </adi:AcceptContentAsset>
  <adi:AcceptContentAsset type="Video" metadataOnly="N" fileName="更上一层楼.mp4_Source_ts(h264+mp2)-20000(19000+256)-19201080-Star_15_ts(h264+mp2)-1900(1600+128)-720576" fileSize="929750804" mD5CheckSum="6011ec51b6620bd95d63b74a8e159cea">
    <vod:Video providerID="CP2301" assetID="CP23010020140626132026" updateNum="1" fileName="更上一层楼.mp4_Source_ts(h264+mp2)-20000(19000+256)-19201080-Star_15_ts(h264+mp2)-1900(1600+128)-720576" fileSize="929750804" mD5CheckSum="6011ec51b6620bd95d63b74a8e159cea" transferContentURL="ftp://icds_war:0wlonewave@125.210.139.14:21/icds-Warehouse10/Video/20140713/20140626233800_gengshangyicenglou_917304875_921284470_925627008.ts" encodingProfile="video/H264" encodingCode="15tsh264mp219001600192720576">
      <adi:AssetLifetime startDateTime="2014-06-26" endDateTime="2064-06-26" />
      <vod:AspectRatio>16:9</vod:AspectRatio>
      <vod:HDFlag>1</vod:HDFlag>
      <vod:Brightness></vod:Brightness>
      <vod:FrameHeight>576</vod:FrameHeight>
      <vod:MimeType>1</vod:MimeType>
      <vod:IsEdit>1</vod:IsEdit>
      <vod:ServiceType>1</vod:ServiceType>
      <vod:NeedDRM>1</vod:NeedDRM>
      <vod:Usage>1</vod:Usage>
      <vod:FrameWidth>720</vod:FrameWidth>
      <vod:VideoCodec>video/H264</vod:VideoCodec>
      <vod:Numberofframes>2</vod:Numberofframes>
      <vod:AudioCodec>mpeg1layer2</vod:AudioCodec>
	  <vod:IsDRM>1</vod:IsDRM>
      <vod:Duration>3915</vod:Duration>
      <vod:FileType>1</vod:FileType>
      <vod:Contrast></vod:Contrast>
      <vod:Bitrate>1600000</vod:Bitrate>
      <vod:FrameRate>25</vod:FrameRate>
    </vod:Video>
  </adi:AcceptContentAsset>
  <adi:AcceptContentAsset type="Video" metadataOnly="N" fileName="更上一层楼.mp4_Source_ts(h264+mp2)-20000(19000+256)-19201080-Star_85_ts(h264+mp2)-2500(2200+192)-1280720" fileSize="1235539760" mD5CheckSum="33951c04a4cd48df3e7942eb8f2d2255">
    <vod:Video providerID="CP2301" assetID="CP23010020140626132025" updateNum="1" fileName="更上一层楼.mp4_Source_ts(h264+mp2)-20000(19000+256)-19201080-Star_85_ts(h264+mp2)-2500(2200+192)-1280720" fileSize="1235539760" mD5CheckSum="33951c04a4cd48df3e7942eb8f2d2255" transferContentURL="ftp://icds_war:0wlonewave@125.210.139.14:21/icds-Warehouse10/Video/20140713/20140626233800_gengshangyicenglou_917304875_921284470_925626950.ts" encodingProfile="video/H264" encodingCode="18tsh264mp2250022001921280720">
      <adi:AssetLifetime startDateTime="2014-06-26" endDateTime="2064-06-26" />
      <vod:AspectRatio>16:9</vod:AspectRatio>
      <vod:HDFlag>0</vod:HDFlag>
      <vod:Brightness></vod:Brightness>
      <vod:FrameHeight>720</vod:FrameHeight>
      <vod:MimeType>1</vod:MimeType>
      <vod:IsEdit>1</vod:IsEdit>
      <vod:ServiceType>1</vod:ServiceType>
      <vod:NeedDRM>1</vod:NeedDRM>
      <vod:Usage>1</vod:Usage>
      <vod:FrameWidth>1280</vod:FrameWidth>
      <vod:VideoCodec>video/H264</vod:VideoCodec>
      <vod:Numberofframes>2</vod:Numberofframes>
      <vod:AudioCodec>mpeg1layer2</vod:AudioCodec>
      <vod:IsDRM>1</vod:IsDRM>
      <vod:Duration>3915</vod:Duration>
      <vod:FileType>1</vod:FileType>
      <vod:Contrast></vod:Contrast>
	  <vod:Bitrate>2200000</vod:Bitrate>
      <vod:FrameRate>25</vod:FrameRate>
    </vod:Video>
  </adi:AcceptContentAsset>
  <adi:AssociateContent type="Image" effectiveDate="" groupProviderID="CP2301" groupAssetID="CP23010020140626132000" providerID="CP2301" assetID="CP23010020140626132003" />
  <adi:AssociateContent type="Image" effectiveDate="" groupProviderID="CP2301" groupAssetID="CP23010020140626132000" providerID="CP2301" assetID="CP23010020140626132006" />
  <adi:AssociateContent type="Image" effectiveDate="" groupProviderID="CP2301" groupAssetID="CP23010020140626132000" providerID="CP2301" assetID="CP23010020140626132002" />
  <adi:AssociateContent type="Image" effectiveDate="" groupProviderID="CP2301" groupAssetID="CP23010020140626132000" providerID="CP2301" assetID="CP23010020140626132004" />
  <adi:AssociateContent type="Video" effectiveDate="" groupProviderID="CP2301" groupAssetID="CP23010020140626132000" providerID="CP2301" assetID="CP23010020140626132026" />
  <adi:AssociateContent type="Video" effectiveDate="" groupProviderID="CP2301" groupAssetID="CP23010020140626132000" providerID="CP2301" assetID="CP23010020140626132025" />
</adi:ADI2>
	';
}